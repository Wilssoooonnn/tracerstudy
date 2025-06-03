<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use Yajra\DataTables\Facades\DataTables;

class PertanyaanController extends Controller
{
    public function index()
    {
        return view('admin.pertanyaan');
    }

    public function list(Request $request)
    {
        $pertanyaans = PertanyaanModel::all();

        return DataTables::of($pertanyaans)
            ->addIndexColumn() // Add an index column for numbering
            ->addColumn('action', function ($pertanyaan) { // Adding action column (edit, delete)
                $btn = '';
                $btn .= '<a href="' . url('/pertanyaan/' . $pertanyaan->id . '/edit') . '" class="btn btn-warning btn-sm">Update</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/pertanyaan/' . $pertanyaan->id) . '">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->addColumn('question_type', function ($pertanyaan) {
                // Check the question type and return the value
                return $pertanyaan->question_type == 'scale' ? 'Scale (1-5)' : 'Text';
            })
            ->rawColumns(['action']) // Telling DataTables that 'action' column contains HTML
            ->make(true);
    }

    public function create()
    {
        return view('admin.pertanyaan_create');
    }

    public function store(Request $request)
    {
        // Validate the input question and question type
        $request->validate([
            'pertanyaan' => 'required|string|min:3', // Pertanyaan must be a string, at least 3 characters
            'question_type' => 'required|in:scale,text', // Validate that question_type is either 'scale' or 'text'
        ]);

        // Create a new Pertanyaan
        PertanyaanModel::create([
            'pertanyaan' => $request->pertanyaan,
            'question_type' => $request->question_type, // Save the question type (either 'scale' or 'text')
        ]);

        return redirect('/pertanyaan')->with('success', 'Data pertanyaan berhasil disimpan');
    }


    // Edit a question
    public function edit($id)
    {
        $pertanyaan = PertanyaanModel::findOrFail($id);

        return view('admin.pertanyaan_edit', compact('pertanyaan'));
    }

    // Update the question
    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string|min:3',
            'question_type' => 'required|in:scale,text', // Validate question_type
        ]);

        $pertanyaan = PertanyaanModel::findOrFail($id);
        $pertanyaan->update([
            'pertanyaan' => $request->pertanyaan,
            'question_type' => $request->question_type, // Update the question type
        ]);

        return redirect('/pertanyaan')->with('success', 'Data pertanyaan berhasil diubah');
    }

    // Delete a question
    public function destroy($id)
    {
        $pertanyaan = PertanyaanModel::find($id);

        if (!$pertanyaan) {
            return redirect('/pertanyaan')->with('error', 'Pertanyaan tidak ditemukan');
        }

        try {
            $pertanyaan->delete(); // Delete the pertanyaan record
            return redirect('/pertanyaan')->with('success', 'Data pertanyaan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/pertanyaan')->with('error', 'Gagal menghapus data, mungkin masih terkait dengan data lain');
        }
    }
}
