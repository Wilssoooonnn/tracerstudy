<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InstansiController extends Controller
{
    /**
     * Menampilkan data instansi dengan AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Instansi::all();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit" data-id="' . $row->id . '">Edit</button>
                            <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
                })
                ->make(true);
        }

        return view('instansi.index');
    }

    /**
     * Menyimpan data instansi baru.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required|string',
            'jenis_instansi' => 'required|string',
            'lokasi_instansi' => 'required|string',
            'skala' => 'required|string',
        ]);

        Instansi::create($request->all());

        return response()->json(['success' => 'Instansi Created Successfully']);
    }

    /**
     * Mengambil data instansi untuk edit.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instansi = Instansi::find($id);
        return response()->json($instansi);
    }

    /**
     * Mengupdate data instansi.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_instansi' => 'required|string',
            'jenis_instansi' => 'required|string',
            'lokasi_instansi' => 'required|string',
            'skala' => 'required|string',
        ]);

        $instansi = Instansi::find($id);
        $instansi->update($request->all());

        return response()->json(['success' => 'Instansi Updated Successfully']);
    }

    /**
     * Menghapus data instansi.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instansi = Instansi::find($id);
        $instansi->delete();

        return response()->json(['success' => 'Instansi Deleted Successfully']);
    }
}
