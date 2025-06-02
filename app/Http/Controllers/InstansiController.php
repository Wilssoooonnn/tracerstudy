<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Instansi;
use Illuminate\Http\Request;
=======
use App\Models\SkalaModel;
use App\Models\LulusanModel;
use App\Models\ProfesiModel;
use Illuminate\Http\Request;
use App\Models\InstansiModel;
use App\Models\KategoriModel;
use App\Models\StakeholderModel;
>>>>>>> 98c88e7d108fe195c687f331d04735baa5d98a64
use Yajra\DataTables\Facades\DataTables;

class InstansiController extends Controller
{
<<<<<<< HEAD
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
=======
    public function cekLulusan()
    {
        return view('instansi.cek-lulusan');
    }

    public function submitCekLulusan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
        ]);

        $inputNama = strtolower(trim($request->nama));

        $alumni = LulusanModel::whereRaw('LOWER(nama) = ?', [$inputNama])->first();

        if (! $alumni) {
            return back()->with('error', 'Nama lulusan tidak ditemukan atau tidak valid. Input: ' . $request->nama);
        }

        return redirect()->route('instansi.form-instansi', [
            'nama' => urlencode($alumni->nama),
        ]);
    }

    public function showFormInstansi($nama)
    {
        $nama = urldecode($nama);

        $alumni = LulusanModel::with('program')
            ->where('nama', $nama)
            ->first();

        if (! $alumni) {
            return redirect()
                ->route('instansi.cek-lulusan')
                ->withErrors(['nama' => 'Nama tidak ditemukan']);
        }

        $semuaSkala    = SkalaModel::all();
        $semuaInstansi = InstansiModel::all();
        $semuaKategori = KategoriModel::all();
        $daftarProfesi = ProfesiModel::with('category')->get();

        return view('instansi.form-instansi', [
            'alumni'        => $alumni,
            'program_nama'  => $alumni->program->program_studi ?? '-',
            'programs_id'   => $alumni->programs_id,
            'nama'          => $alumni->nama,
            'tanggal_lulus' => $alumni->tanggal_lulus,
            'no_hp'         => $alumni->no_hp,
            'email'         => $alumni->email,
            'skala_id'      => $alumni->skala_id,
            'semuaSkala'    => $semuaSkala,
            'semuaInstansi' => $semuaInstansi,
            'semuaKategori' => $semuaKategori,
            'daftarProfesi' => $daftarProfesi,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'                    => 'required|exists:lulusan,nim',
            'no_hp'                  => 'required|max:20',
            'email'                  => 'required|email',
            'tanggal_pertama_kerja'  => 'required|date',
            'instansi_id'            => 'required|exists:instansi,id',
            'skala_id'               => 'required|exists:skala,id',
            'kategori_id'            => 'required|exists:category,id',
            'profesi_id'             => 'required',
            'profesi_baru'           => 'required_if:profesi_id,lainnya|max:255',
        ]);

        if ($request->profesi_id === 'lainnya') {
            $profesiBaru = ProfesiModel::create([
                'profesi'     => $request->profesi_baru,
                'category_id' => 1,
            ]);
            $profesi_id = $profesiBaru->id;
        } else {
            $profesi_id = $request->profesi_id;
        }

        $alumni = LulusanModel::where('nim', $request->nim)->first();
        $alumni->no_hp                 = $request->no_hp;
        $alumni->email                 = $request->email;
        $alumni->tanggal_pertama_kerja = $request->tanggal_pertama_kerja;
        $alumni->instansi_id           = $request->instansi_id;
        $alumni->skala_id              = $request->skala_id;
        $alumni->kategori_id           = $request->kategori_id;
        $alumni->profesi_id            = $profesi_id;
        $alumni->save();

        return redirect()
            ->back()
            ->with('success', 'Data berhasil disimpan.');
    }

    public function index(){
        return view('admin.data_stakeholder');
    }

    public function list(Request $request)
    {
    $stakeholders = StakeholderModel::with('lulusan');


    return DataTables::of($stakeholders)
    // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
    ->addIndexColumn()
    ->addColumn('nama_alumni', function($row) {
            return $row->data_alumni->nama ?? '-';
    })
    ->addColumn('action', function ($stakeholder) { // menambahkan kolom aksi
        $btn = '';
        $btn .= '<a href="'.url('/instansi/' . $stakeholder->id).'" class="btn btn-warning btn-sm">Detail</a>';

    return $btn;
    })

    ->rawColumns(['action']) // memberitahu bahwa kolom aksi adalah html
    ->make(true);
    }

    public function show($id)
    {
        $stakeholder = StakeholderModel::find($id);

        return view('admin.stakeholder_show', compact('stakeholder'));
    }

>>>>>>> 98c88e7d108fe195c687f331d04735baa5d98a64
}
