<?php

namespace App\Http\Controllers;

use App\Models\LulusanModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class RekapLulusanController extends Controller
{
    public function index(){
        return view('admin.rekap_belum_mengisi_lulusan');
    }

    public function list(Request $request){
        $alumni = LulusanModel::with('program')
        ->select('id', 'nim', 'nama', 'programs_id')
        ->whereNull('email')
        ->whereNull('nohp')
        ->get();

        return DataTables::of($alumni)
        ->addIndexColumn() // menambahkan kolom nomor urut
        ->addColumn('prodi', function ($row) {
            return $row->program ? $row->program->program_studi : '-';
        })
        ->make(true);

    }

    public function export_excel()
    {    
        $alumni = LulusanModel::with('program')
        ->select('id', 'nim', 'nama', 'programs_id','tanggal_lulus')
        ->whereNull('email')
        ->whereNull('nohp')
        ->get();

    
        // buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Program Studi');
        $sheet->setCellValue('C1', 'NIM');
        $sheet->setCellValue('D1', 'Nama');
        $sheet->setCellValue('E1', 'Tanggal Lulus');
    
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
    
        $no = 1;
        $baris = 2;
        foreach ($alumni as $lulusan) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $lulusan->program->program_studi ?? '-'); // program_studi program studi dari relasi
            $sheet->setCellValue('C' . $baris, $lulusan->nim);
            $sheet->setCellValue('D' . $baris, $lulusan->nama);
            $sheet->setCellValue('E' . $baris, $lulusan->tanggal_lulus ?? '-');
            $baris++;
            $no++;
        }
    
        // set auto size kolom A sampai D
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        $sheet->setTitle('Rekap Belum Mengisi Lulusan');
    
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Rekap Belum Mengisi Lulusan ' . date('Y-m-d_H-i-s') . '.xlsx';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        exit;
    }

    
}
