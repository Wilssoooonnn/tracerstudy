<?php
namespace App\Http\Controllers;

use App\Models\Alumni;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Alumni::with(['programStudi', 'instansi', 'kategoriProfesi']);

            return DataTables::of($data)
                ->addIndexColumn() // This automatically adds DT_RowIndex to your data
                ->addColumn('program_studi', function ($row) {
                    return $row->programStudi ? $row->programStudi->nama_program_studi : 'N/A';  // Program Studi
                })
                ->addColumn('instansi', function ($row) {
                    return $row->instansi ? $row->instansi->nama_instansi : 'N/A';  // Instansi
                })
                ->addColumn('kategori_profesi', function ($row) {
                    return $row->kategoriProfesi ? $row->kategoriProfesi->kategori_profesi : 'N/A';  // Kategori Profesi
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.alumni.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>
                        <form action="' . route('admin.alumni.destroy', $row->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>';
                })
                ->make(true);  // Return the response in the required format
        }

        return view('admin.alumni.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'program_studi_id' => 'required|exists:program_studi,id',
            'tahun_lulus' => 'required',
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'required|email',
            'tanggal_pertama_kerja' => 'required|date',
            'tanggal_mulai_kerja_instansi' => 'required|date',
            'instansi_id' => 'required|exists:instansi,id',
            'kategori_profesi_id' => 'required|exists:kategori_profesi,id',
            'profesi' => 'required|string',
            'nama_atasan_langsung' => 'required|string',
            'jabatan_atasan_langsung' => 'required|string',
            'no_hp_atasan_langsung' => 'required|string',
            'email_atasan_langsung' => 'required|email',
        ]);

        Alumni::create($request->all());

        return response()->json(['success' => 'Alumni Created Successfully']);
    }

    public function edit($id)
    {
        $alumni = Alumni::find($id);
        return response()->json($alumni);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program_studi_id' => 'required|exists:program_studi,id',
            'tahun_lulus' => 'required',
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'required|email',
            'tanggal_pertama_kerja' => 'required|date',
            'tanggal_mulai_kerja_instansi' => 'required|date',
            'instansi_id' => 'required|exists:instansi,id',
            'kategori_profesi_id' => 'required|exists:kategori_profesi,id',
            'profesi' => 'required|string',
            'nama_atasan_langsung' => 'required|string',
            'jabatan_atasan_langsung' => 'required|string',
            'no_hp_atasan_langsung' => 'required|string',
            'email_atasan_langsung' => 'required|email',
        ]);

        $alumni = Alumni::find($id);
        $alumni->update($request->all());

        return response()->json(['success' => 'Alumni Updated Successfully']);
    }

    public function destroy($id)
    {
        $alumni = Alumni::find($id);
        $alumni->delete();

        return response()->json(['success' => 'Alumni Deleted Successfully']);
    }
}
