<?php

namespace App\Http\Controllers;

use App\Models\LulusanModel;
use App\Models\TracerRecordModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class TracerStudyController extends Controller
{
    public function index()
    {
        return view('admin.rekap_hasil_lulusan');
    }

    public function list(Request $request)
    {
        $alumni = LulusanModel::with('program', 'tracerRecord')
            ->whereHas('tracerRecord') // hanya ambil alumni yang punya tracer record
            ->select('id', 'nim', 'nama', 'programs_id', 'nohp', 'email')
            ->get();

        return DataTables::of($alumni)
            ->addIndexColumn()
            ->addColumn('prodi', function ($row) {
                return $row->program ? $row->program->program_studi : '-';
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . url('/rekaphasil/' . $row->id) . '" class="btn btn-primary btn-sm">Detail</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($id)
    {
        $tracerRecord = TracerRecordModel::with('data_alumni', 'instansi', 'skala', 'category', 'profesi')
            ->where('alumni_id', $id)->first();
        
        if (!$tracerRecord) {
            return back()->with('error', 'Data tidak ditemukan atau belum diisi.');
        }

        // Hitung masa tunggu dalam bulan
        $masaTunggu = null;
        if ($tracerRecord->first_job_date && $tracerRecord->data_alumni && $tracerRecord->data_alumni->tanggal_lulus) {
            $tglKerja = Carbon::parse($tracerRecord->first_job_date);
            $tglLulus = Carbon::parse($tracerRecord->data_alumni->tanggal_lulus);

            // Bisa pakai diffInMonths atau hitung manual jika ingin lebih detail
            $masaTunggu = $tglLulus->diffInMonths($tglKerja, false); // hasil bisa negatif kalau kerja sebelum lulus
        }

        return view('admin.rekapTS_show', compact('tracerRecord', 'masaTunggu'));
    }

    public function export_rekap_tracer_study()
    {
        $tracerRecords = TracerRecordModel::with(['data_alumni', 'instansi', 'skala', 'category', 'profesi'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Program Studi',
            'B1' => 'NIM',
            'C1' => 'Nama',
            'D1' => 'No.HP',
            'E1' => 'Email',
            'F1' => 'Tanggal Lulus',
            'G1' => 'Tahun Lulus',
            'H1' => 'Tanggal Pertama Kerja',
            'I1' => 'Masa Tunggu',
            'J1' => 'Tanggal Mulai Kerja Instansi Saat Ini',
            'K1' => 'Jenis Instansi',
            'L1' => 'Nama Instansi',
            'M1' => 'Skala',
            'N1' => 'Lokasi Instansi',
            'O1' => 'Kategori Profesi',
            'P1' => 'Profesi',
            'Q1' => 'Nama Atasan Langsung',
            'R1' => 'Jabatan Atasan Langsung',
            'S1' => 'No HP Atasan Langsung',
            'T1' => 'Email Atasan Langsung'
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }
        $sheet->getStyle('A1:T1')->getFont()->setBold(true);

        $row = 2;
        foreach ($tracerRecords as $record) {
            // Hitung masa tunggu dalam bulan
            $masaTunggu = null;
            if ($record->first_job_date && $record->data_alumni && $record->data_alumni->tanggal_lulus) {
                $tglKerja = Carbon::parse($record->first_job_date);
                $tglLulus = Carbon::parse($record->data_alumni->tanggal_lulus);
                $masaTunggu = $tglLulus->diffInMonths($tglKerja, false); // Bisa negatif kalau kerja sebelum lulus
            }

            $sheet->setCellValue('A' . $row, $record->data_alumni->program->program_studi ?? '-');
            $sheet->setCellValue('B' . $row, $record->data_alumni->nim ?? '-');
            $sheet->setCellValue('C' . $row, $record->data_alumni->nama ?? '-');
            $sheet->setCellValue('D' . $row, $record->data_alumni->nohp ?? '-');
            $sheet->setCellValue('E' . $row, $record->data_alumni->email ?? '-');
            $sheet->setCellValue('F' . $row, $record->data_alumni->tanggal_lulus ? date('d/m/Y', strtotime($record->data_alumni->tanggal_lulus)) : '-');
            $sheet->setCellValue('G' . $row, $record->data_alumni->tanggal_lulus ?? '-');
            $sheet->setCellValue('H' . $row, $record->first_job_date ? date('d/m/Y', strtotime($record->first_job_date)) : '-');
            $sheet->setCellValue('I' . $row, $masaTunggu !== null ? $masaTunggu . ' bulan' : '-');
            $sheet->setCellValue('J' . $row, $record->current_instansi_start_date ? date('d/m/Y', strtotime($record->current_instansi_start_date)) : '-');
            $sheet->setCellValue('K' . $row, $record->instansi->instansi_nama ?? '-');
            $sheet->setCellValue('L' . $row, $record->instansi_name ?? '-');
            $sheet->setCellValue('M' . $row, $record->skala->skala_nama ?? '-');
            $sheet->setCellValue('N' . $row, $record->instansi_location ?? '-');
            $sheet->setCellValue('O' . $row, $record->category->category ?? '-');
            $sheet->setCellValue('P' . $row, $record->profesi->profesi ?? '-');
            $sheet->setCellValue('Q' . $row, $record->nama_atasan ?? '-');
            $sheet->setCellValue('R' . $row, $record->jabatan ?? '-');
            $sheet->setCellValue('S' . $row, $record->no_hp ?? '-');
            $sheet->setCellValue('T' . $row, $record->email ?? '-');

            $row++;
        }

        foreach (range('A', 'T') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Rekap Tracer Studi Lulusan');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Rekap Tracer Studi' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
