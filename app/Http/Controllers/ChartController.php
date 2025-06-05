<?php

// app/Http/Controllers/ChartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

    public function topProfesi()
    {
        // Ambil jumlah lulusan per profesi
        $allData = DB::table('tracer_record')
            ->join('profesi', 'tracer_record.profession_id', '=', 'profesi.id')
            ->select('profesi.profesi', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('profesi.profesi')
            ->orderByDesc('jumlah')
            ->get();

        // Ambil 10 profesi teratas
        $top10 = $allData->take(10);
        $lainnyaTotal = $allData->skip(10)->sum('jumlah');

        $result = $top10->toArray();

        if ($lainnyaTotal > 0) {
            $result[] = (object)[
                'profesi' => 'Lainnya',
                'jumlah' => $lainnyaTotal
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
