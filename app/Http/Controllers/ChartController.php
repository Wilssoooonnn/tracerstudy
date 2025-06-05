<?php

// app/Http/Controllers/ChartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
