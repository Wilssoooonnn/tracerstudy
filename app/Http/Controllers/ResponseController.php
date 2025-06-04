<?php

namespace App\Http\Controllers;

use App\Models\ResponsModel;
use Illuminate\Http\Request;
use App\Models\StakeholderModel;
use Yajra\DataTables\Facades\DataTables;

class ResponseController extends Controller
{
    public function index(){
        return view('admin.response_data');
    }

    public function list(Request $request)
    {
        // Select specific columns and eager load the 'level' relationship
    $stakeholder = ResponsModel::with('stakeholder') // relasi ke model data_stakeholder
        ->select('stakeholder_id')
        ->groupBy('stakeholder_id')
        ->get();

    return DataTables::of($stakeholder)
        ->addIndexColumn()
        ->addColumn('nama_stakeholder', function ($row) {
            return $row->stakeholder->nama ?? '-';
        })
        ->addColumn('nama_instansi', function ($row) {
            return $row->stakeholder->instansi ?? '-';
        })
        ->addColumn('action', function ($row) {
            $btn = '<a href="'.url('/response/' . $row->stakeholder_id) .'" class="btn btn-info btn-sm">Detail</a> ';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function show($stakeholder_id)
    {
    // Ambil stakeholder dan semua responnya
    $stakeholder =StakeholderModel::findOrFail($stakeholder_id);

    $responses = \App\Models\ResponsModel::with('pertanyaan')
        ->where('stakeholder_id', $stakeholder_id)
        ->get();

    return view('admin.respon_detail', compact('stakeholder', 'responses'));
    }

}
