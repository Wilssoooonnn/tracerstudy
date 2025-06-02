<?php

namespace App\Http\Controllers;

use Log;
use App\Models\LulusanModel;
use App\Models\ProfesiModel;
use Illuminate\Http\Request;
use App\Models\FormlulusanModel;
use App\Models\StakeholderModel;

class FormlulusanController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'nim' => 'required|exists:data_alumni,nim',
            'no_hp' => 'required|max:20',
            'email' => 'required|email',
            'tanggal_pertama_kerja' => 'required|date',
            'tanggal_mulai_kerja' => 'required|date',
            'instansi_id' => 'required|exists:instansi,id',
            'nama_instansi' => 'required',
            'skala_id' => 'required|exists:skala,id',
            'lokasi_instansi' => 'required',
            'kategori_id' => 'required|exists:category,id',
            'profesi_id' => 'nullable',
            'profesi_input' => 'required_without:profesi_id|string|max:255',
            'nama_atasan' => 'required',
            'jabatan' => 'required',
            'noHp_atasan' => 'required',
            'email_atasan' => 'required|email',
        ]);


        // Determine the profession to use
        $profesi = $this->resolveProfesi(
            $request->profesi_input,
            $request->profesi_id,  // Use profesi_id from request
            $request->kategori_id
        );


        if (!$profesi) {
            return back()->withErrors(['profesi_text' => 'Profesi tidak valid']);
        }

        // If profesi_id is provided, use it
        if ($request->filled('profesi_id') && is_numeric($request->profesi_id)) {
            $profesi = ProfesiModel::findOrFail($request->profesi_id);
        } else {
            // If input is provided as new profession (profesi_input)
            $profesi = ProfesiModel::firstOrCreate(
                ['profesi' => $request->profesi_input],
                ['category_id' => $request->kategori_id]
            );
        }

        // UPDATE alumni data in data_alumni table
        $alumni = LulusanModel::where('nim', $request->nim)->first();
        if ($alumni) {
            $alumni->nohp = $request->no_hp;
            $alumni->email = $request->email;
            $alumni->save();
        } else {
            return back()->withErrors(['nim' => 'Alumni not found']);
        }


        // INSERT into tracer_record
        FormlulusanModel::create([
            'alumni_id' => $alumni->id,
            'first_job_date' => $request->tanggal_pertama_kerja,
            'current_instansi_start_date' => $request->tanggal_mulai_kerja,
            'instansi_type' => $request->instansi_id,
            'instansi_name' => $request->nama_instansi,
            'instansi_scale' => $request->skala_id,
            'instansi_location' => $request->lokasi_instansi,
            'category_profession' => $request->kategori_id,
            'profession_id' => $profesi->id,
            'nama_atasan' => $request->nama_atasan,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->noHp_atasan,
            'email' => $request->email_atasan,
        ]);


        // INSERT into stakeholder
        StakeholderModel::create([
            'nama' => $request->nama_atasan,
            'instansi' => $request->nama_instansi,
            'jabatan' => $request->jabatan,
            'email' => $request->email_atasan,
            'alumni_id' => $alumni->id
        ]);


        // Return success response
        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Resolve the profession (profesi) based on input or ID.
     *
     * @param string|null $profesiNama
     * @param string|null $profesiId
     * @param string $kategoriId
     * @return ProfesiModel|null
     */
    private function resolveProfesi($profesiNama, $profesiId, $kategoriId)
    {
        if ($profesiId && is_numeric($profesiId)) {
            return ProfesiModel::findOrFail($profesiId);
        }

        return ProfesiModel::firstOrCreate(
            ['profesi' => $profesiNama],
            ['category_id' => $kategoriId]
        );
    }

}
