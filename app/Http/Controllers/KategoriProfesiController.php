<?php

namespace App\Http\Controllers;

use App\Models\KategoriProfesi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriProfesiController extends Controller
{
    /**
     * Menampilkan data kategori profesi dengan AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriProfesi::all();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit" data-id="' . $row->id . '">Edit</button>
                            <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
                })
                ->make(true);
        }

        return view('kategori_profesi.index');
    }

    /**
     * Menyimpan data kategori profesi baru.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_profesi' => 'required|string',
        ]);

        KategoriProfesi::create($request->all());

        return response()->json(['success' => 'Kategori Profesi Created Successfully']);
    }

    /**
     * Mengambil data kategori profesi untuk edit.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategoriProfesi = KategoriProfesi::find($id);
        return response()->json($kategoriProfesi);
    }

    /**
     * Mengupdate data kategori profesi.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_profesi' => 'required|string',
        ]);

        $kategoriProfesi = KategoriProfesi::find($id);
        $kategoriProfesi->update($request->all());

        return response()->json(['success' => 'Kategori Profesi Updated Successfully']);
    }

    /**
     * Menghapus data kategori profesi.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategoriProfesi = KategoriProfesi::find($id);
        $kategoriProfesi->delete();

        return response()->json(['success' => 'Kategori Profesi Deleted Successfully']);
    }
}
