<?php

namespace App\Http\Controllers;

use App\Models\ProfesiModel;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;

class ProfesiController extends Controller
{
    public function index(){
        return view('admin.profesi');
    }

    public function list(){

        $profesi = ProfesiModel::select('id','category_id','profesi')
        ->with('category');

        return DataTables::of($profesi)
        // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('category_id', function ($row) {
        return $row->category->category ?? '-';
        })
        ->addColumn('action', function ($profesi) { // menambahkan kolom aksi
        $btn = '';
        $btn .= '<form class="d-inline-block" method="POST" action="'.url('/profesi/'.$profesi->id).'">'. csrf_field() . method_field('DELETE') .'<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Delete</button></form>';

        return $btn;

        })
        ->rawColumns(['action']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);

    }

    public function create()
    {
        $kategori = KategoriModel::all();
        return view('admin.profesi_create',compact('kategori'));
    }

    public function store(Request $request)
    {
        // Validate the input question and question type
        $request->validate([
            'profesi' => 'required|string|min:3', // Pertanyaan must be a string, at least 3 characters
            'category_type' => 'required|exists:category,id', // Validate that question_type is either 'scale' or 'text'
        ]);

        // Create a new Pertanyaan
        ProfesiModel::create([
            'profesi' => $request->profesi,
            'category_id' => $request->category_type, // Save the question type (either 'scale' or 'text')
        ]);

        return redirect('/profesi')->with('success', 'Data Profesi Baru Berhasil Disimpan');
    }

        public function destroy($id)
    {
        $profesi = ProfesiModel::find($id);

        if (!$profesi) {
            return redirect('/profesi')->with('error', 'Data Profesi tidak ditemukan');
        }

        try {
            $profesi->delete(); // Delete the pertanyaan record
            return redirect('/profesi')->with('success', 'Data Profesi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/profesi')->with('error', 'Gagal menghapus data, mungkin masih terkait dengan data lain');
        }
    }
}
