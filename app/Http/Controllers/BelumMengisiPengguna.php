<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BelumMengisiPengguna extends Controller
{
    public function index()
    {
        return view('admin.rekap_belum_mengisi_pengguna');
    }

    // Data untuk tampil di DataTables (simple)
    public function list(Request $request)
    {
        $pengguna = DB::table('data_stakeholder as a')
            ->leftJoin('respon as b', 'a.id', '=', 'b.stakeholder_id')
            ->select(
                'a.nama as nama',
                'a.instansi as instansi',
                'a.jabatan as jabatan'
            )
            ->whereNull('b.stakeholder_id')
            ->get();

        return DataTables::of($pengguna)
            ->addIndexColumn()
            ->make(true);
    }

    // Data untuk ekspor Excel (lengkap)
    public function export_excel_pengguna()
    {
        $pengguna = DB::table('data_stakeholder as ds')
            ->leftJoin('respon as r', 'ds.id', '=', 'r.stakeholder_id')
            ->join('data_alumni as da', 'ds.alumni_id', '=', 'da.id')
            ->join('programs as p', 'da.programs_id', '=', 'p.id')
            ->leftJoin('tracer_record as tr', 'da.id', '=', 'tr.alumni_id')
            ->select(
                'ds.nama as nama_atasan',
                'ds.instansi',
                'ds.jabatan',
                'tr.no_hp as no_hp_atasan',
                'da.nama as nama_alumni',
                'p.program_studi',
                DB::raw('YEAR(da.tanggal_lulus) as tahun_lulus')
            )
            ->whereNull('r.stakeholder_id')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Atasan');
        $sheet->setCellValue('C1', 'Instansi');
        $sheet->setCellValue('D1', 'Jabatan');
        $sheet->setCellValue('E1', 'No HP Atasan');
        $sheet->setCellValue('F1', 'Nama Alumni');
        $sheet->setCellValue('G1', 'Program Studi');
        $sheet->setCellValue('H1', 'Tahun Lulus');

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($pengguna as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item->nama_atasan ?? '-');
            $sheet->setCellValue('C' . $baris, $item->instansi ?? '-');
            $sheet->setCellValue('D' . $baris, $item->jabatan ?? '-');
            $sheet->setCellValue('E' . $baris, $item->no_hp_atasan ?? '-');
            $sheet->setCellValue('F' . $baris, $item->nama_alumni ?? '-');
            $sheet->setCellValue('G' . $baris, $item->program_studi ?? '-');
            $sheet->setCellValue('H' . $baris, $item->tahun_lulus ?? '-');
            $baris++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setTitle('Rekap Belum Mengisi Stakeholder');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Rekap_Belum_Mengisi_Stakeholder_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}