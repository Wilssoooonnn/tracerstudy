<?php

namespace App\Http\Controllers;

use App\Models\ResponsModel;
use App\Models\StakeholderModel;
use App\Models\PertanyaanModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class RekapSurveyController extends Controller
{
    public function index()
    {
        return view('admin.rekap_hasil_surveykepuasan');
    }

    public function list(Request $request)
    {
        $query = StakeholderModel::with(['lulusan.program'])
            ->whereHas('respon') // Hanya yang punya relasi respon (sudah isi form)
            ->select('data_stakeholder.*');
    
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama_stakeholder', fn($row) => $row->nama ?? '-')
            ->addColumn('nama_instansi', fn($row) => $row->instansi ?? '-')
            ->addColumn('nama_jabatan', fn($row) => $row->jabatan ?? '-')
            ->addColumn('email', fn($row) => $row->email ?? '-')
            ->addColumn('nama_alumni', fn($row) => $row->lulusan ? $row->lulusan->nama : '-')
            ->addColumn('program_studi', fn($row) => ($row->lulusan && $row->lulusan->program) ? $row->lulusan->program->program_studi : '-')
            ->addColumn('tahun_lulus', fn($row) => $row->lulusan ? $row->lulusan->tanggal_lulus : '-')
            ->addColumn('action', function($row) {
                return '<a href="' . url('/rekaphasilsurvey/' . $row->id) . '" class="btn btn-primary btn-sm">Detail</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($stakeholder_id)
    {
        $stakeholder = StakeholderModel::with('lulusan')->findOrFail($stakeholder_id);
    
        $responList = ResponsModel::with('pertanyaan')
            ->where('stakeholder_id', $stakeholder_id)
            ->get();
    
        $skalaKeterangan = [
            5 => 'Sangat Baik',
            4 => 'Baik',
            3 => 'Cukup',
            2 => 'Kurang',
            1 => 'Sangat Kurang',
        ];
    
        $penilaian = $responList->map(function ($item) use ($skalaKeterangan) {
            return [
                'pertanyaan' => $item->pertanyaan->pertanyaan ?? '-',
                'nilai' => $item->respon,
                'keterangan' => $skalaKeterangan[$item->respon] ?? '-',
            ];
        });
    
        return view('admin.rekapSurvey_show', compact('penilaian', 'stakeholder'));
    }

public function export_rekap_hasil_survey()
{
    $stakeholders = StakeholderModel::with(['lulusan.program', 'respon.pertanyaan'])
        ->whereHas('respon')
        ->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header awal
    $headers = [
        'Nama', 'Instansi', 'Jabatan', 'Email',
        'Nama Alumni', 'Program Studi', 'Tahun Lulus'
    ];

    // Ambil semua pertanyaan dari database
    $pertanyaanList = PertanyaanModel::orderBy('id')->get();

    foreach ($pertanyaanList as $pertanyaan) {
        $headers[] = $pertanyaan->pertanyaan;
    }

    // Tulis header ke baris pertama
    $col = 'A';
    foreach ($headers as $header) {
        $cell = $col . '1';
        $sheet->setCellValue($cell, $header);
        $sheet->getStyle($cell)->getFont()->setBold(true);
        $col++;
    }

    $skalaKeterangan = [
        5 => 'Sangat Baik',
        4 => 'Baik',
        3 => 'Cukup',
        2 => 'Kurang',
        1 => 'Sangat Kurang',
    ];

    $row = 2;

    foreach ($stakeholders as $stakeholder) {
        $sheet->setCellValue('A' . $row, $stakeholder->nama ?? '-');
        $sheet->setCellValue('B' . $row, $stakeholder->instansi ?? '-');
        $sheet->setCellValue('C' . $row, $stakeholder->jabatan ?? '-');
        $sheet->setCellValue('D' . $row, $stakeholder->email ?? '-');
        $sheet->setCellValue('E' . $row, $stakeholder->lulusan->nama ?? '-');
        $sheet->setCellValue('F' . $row, $stakeholder->lulusan->program->program_studi ?? '-');
        $sheet->setCellValue('G' . $row, $stakeholder->lulusan->tanggal_lulus ?? '-');

        // Jawaban pertanyaan
        $responMap = $stakeholder->respon->keyBy('pertanyaan_id');

        $colIndex = 8; // Kolom H
        foreach ($pertanyaanList as $pertanyaan) {
            $responValue = $responMap[$pertanyaan->id]->respon ?? null;

            if (in_array($responValue, [1, 2, 3, 4, 5])) {
                $keterangan = $skalaKeterangan[(int)$responValue];
            } else {
                $keterangan = $responValue ?? '-';
            }

            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
            $sheet->setCellValue($colLetter . $row, $keterangan);
        }

        $row++;
    }

    foreach (range('A', $sheet->getHighestColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $sheet->setTitle('Rekap Hasil Survey');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Rekap Hasil Survey Kepuasan ' . date('Y-m-d_H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}
}