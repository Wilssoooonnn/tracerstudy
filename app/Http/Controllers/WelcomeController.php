<?php

namespace App\Http\Controllers;

use App\Models\LulusanModel;
use App\Models\StakeholderModel;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
{
    $jumlahLulusan = LulusanModel::count(); // hitung total data alumni
    $lulusanIsiLulusan = LulusanModel::whereNotNull('nohp')
                                       ->whereNotNull('email')
                                       ->count();
    $jumlahInstansi = StakeholderModel::count(); 
    // $jumlahIsiInstansi = StakeholderModel::whereNotNull('id_respons')
    //                                     ->count();

    return view('welcome', compact('jumlahLulusan', 'lulusanIsiLulusan','jumlahInstansi'));
}
}
