<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PertanyaanController extends Controller
{
    public function index(){
        return view('admin.pertanyaan');
    }

    public function list(Request $request)
    {
    $pertanyaans = PertanyaanModel::all();

    return DataTables::of($pertanyaans)
    // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
    ->addIndexColumn()
    ->addColumn('action', function ($pertanyaan) { // menambahkan kolom aksi
        $btn = '';
        $btn .= '<a href="'.url('/pertanyaan/' . $pertanyaan->id . '/edit').'" class="btn btn-warning btn-sm">Update</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="'. url('/pertanyaan/'.$pertanyaan->id).'">'. csrf_field() . method_field('DELETE') .
        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';

    return $btn;

    })

    ->rawColumns(['action']) // memberitahu bahwa kolom aksi adalah html
    ->make(true);
    }

    public function create()
    {
        $pertanyaans = PertanyaanModel::select('pertanyaan')->get();

       return view('admin.pertanyaan_create', compact('pertanyaans'));

    }

    public function store(Request $request)
    {

    $request->validate([
    // pertanyaan harus diisi, berupa string, minimal 3 karakter
    'pertanyaan' => 'required|string|min:3',    
    ]);

    PertanyaanModel::create([
        'pertanyaan' => $request->pertanyaan,
    ]);

    return redirect('/pertanyaan')->with('success', 'Data pertanyaan berhasil disimpan');

    }

// Menampilkan halaman form edit user
public function edit($id)
{
    $pertanyaans = PertanyaanModel::find($id);

    return view('admin.pertanyaan_edit', ['pertanyaan' => $pertanyaans] );
}

// Menyimpan perubahan data user
public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan'  => 'required|string|min:3'
        ]);

        PertanyaanModel::find($id)->update([
            'pertanyaan'  => $request->pertanyaan
            
        ]);

        return redirect('/pertanyaan')->with('success', 'Data user berhasil diubah');
    }

// Menghapus data user
    public function destroy(string $id)
    {
        $check = PertanyaanModel::find($id);
        if (!$check) { // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/pertanyaan')->with('error', 'Pertanyaan tidak ditemukan');
        }

        try {
            PertanyaanModel::destroy($id); // Hapus data user
            return redirect('/pertanyaan')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/pertanyaan')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini ini');
        }
    }

}

