<?php

// app/Http/Controllers/ChartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PertanyaanModel;
use App\Models\ResponsModel;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

    public function topProfesi()
    {
        // Ambil data profesi dan jumlah lulusan
        $allData = DB::table('tracer_record')
            ->join('profesi', 'tracer_record.profession_id', '=', 'profesi.id')
            ->select('profesi.profesi', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('profesi.profesi')
            ->orderByDesc('jumlah')
            ->get();
    
        // Hitung total keseluruhan lulusan
        $total = $allData->sum('jumlah');
    
        // Hitung persentase dan tambahkan ke setiap item dalam format string dengan '%'
        $allData = $allData->map(function ($item) use ($total) {
            $persentase = ($item->jumlah / $total) * 100;
            $item->persentase = round($persentase, 1) . '%';
            return $item;
        });
    
        // Ambil 5 besar berdasarkan jumlah terbanyak
        $top5 = $allData->take(5);
    
        // Sisanya masuk ke dalam kategori "Lainnya"
        $lainnya = $allData->skip(5);
    
        $lainnyaTotal = $lainnya->sum('jumlah');
        $lainnyaPersentase = ($lainnyaTotal / $total) * 100;
    
        $result = $top5->toArray();
    
        // Tambahkan data "Lainnya" jika ada
        if ($lainnyaTotal > 0) {
            $result[] = (object)[
                'profesi' => 'Lainnya',
                'jumlah' => $lainnyaTotal,
                'persentase' => round($lainnyaPersentase, 1) . '%'
            ];
        }
    
        return response()->json($result);
    }

    public function jenisInstansi()
    {
        $data = DB::table('tracer_record')
            ->join('instansi', 'tracer_record.instansi_type', '=', 'instansi.id')
            ->select('instansi.instansi_nama', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('instansi.instansi_nama')
            ->get();

        return response()->json($data);
    }

    public function penilaianKepuasan()
    {
        $pertanyaan = PertanyaanModel::all();
    
        // Mapping pertanyaan ke canvas_id sesuai urutan dan id canvas yang ada di frontend
        $mappingCanvasId = [
            'Kerja Sama Tim' => 'Kerja',
            'Keahlian Bidang TI' => 'Keahlian',
            'Kemampuan Berbahasa Asing' => 'Kemampuan',
            'Kemampuan Berkomunikasi' => 'Berkomunikasi',
            'Pengembangan Diri' => 'Pengembangan',
            'Kepemimpinan' => 'Kepemimpinan',
            'Etos Kerja' => 'Etos',
        ];
    
        $result = [];
    
        foreach ($pertanyaan as $p) {
            $skala = [];
    
            // Hitung jumlah responden per nilai (1 - 5)
            for ($i = 1; $i <= 5; $i++) {
                $skala[] = ResponsModel::where('pertanyaan_id', $p->id)
                    ->where('respon', $i)
                    ->count();
            }
    
            $canvas_id = $mappingCanvasId[$p->pertanyaan] ?? null;
    
            if ($canvas_id) { // hanya tambahkan jika canvas_id sesuai mapping
                $result[] = [
                    'id' => $p->id,
                    'label' => $p->pertanyaan,
                    'canvas_id' => $canvas_id,
                    'data' => $skala,
                ];
            }
        }
    
        return response()->json($result);
    }    

}
