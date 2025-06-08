<?php

namespace App\Http\Controllers;

use App\Models\LulusanModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\DB;

class RekapLulusanController extends Controller
{
    public function index()
    {
        return view('admin.rekap_belum_mengisi_pengguna'); // Update view name
    }

    public function list(Request $request)
    {
        $pengguna = DB::table('data_stakeholder as a')
                    ->rightjoin('data_alumni as b', 'a.alumni_id', '=', 'b.id')
                    ->join('programs as c', 'b.programs_id', '=', 'c.id')
                    ->select(
                        'a.nama as nama_atasan',
                        'a.instansi as stackholder',
                        'b.nama as nama_lulusan',
                        'c.program_studi as program_studi'
                    )
                    ->whereNull('b.email')
                    ->whereNull('b.nohp')
                    ->get();

        return DataTables::of($pengguna)
            ->addIndexColumn()
            ->addColumn('program_studi', function ($row) {
                return $row->program_studi ?? '-';
            })
            ->make(true);
    }

    public function export_excel_pengguna()
    {
        $pengguna = DB::table('data_stakeholder as a')
                    ->rightjoin('data_alumni as b', 'a.alumni_id', '=', 'b.id')
                    ->join('programs as c', 'b.programs_id', '=', 'c.id')
                    ->select(
                        'a.nama as nama_atasan',
                        'a.instansi as stackholder',
                        'b.nama as nama_lulusan',
                        'c.program_studi as program_studi'
                    )
                    ->whereNull('b.email')
                    ->whereNull('b.nohp')
                    ->get();

        // Create new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header columns
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Atasan');
        $sheet->setCellValue('C1', 'Stakeholder');
        $sheet->setCellValue('D1', 'Nama Lulusan');
        $sheet->setCellValue('E1', 'Program Studi');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2; // Start from the second row
        foreach ($pengguna as $lulusan) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $lulusan->nama_atasan ?? '-'); // Nama Atasan
            $sheet->setCellValue('C' . $baris, $lulusan->stakeholder ?? '-'); // Stakeholder
            $sheet->setCellValue('D' . $baris, $lulusan->nama_lulusan);
            $sheet->setCellValue('E' . $baris, $lulusan->program_studi ?? '-');
            $baris++;
            $no++;
        }

        // Set auto size for columns
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Rekap Belum Mengisi Stackholder'); // Set title

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Rekap Belum Mengisi Stackholder' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
