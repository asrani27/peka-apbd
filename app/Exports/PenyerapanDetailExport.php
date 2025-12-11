<?php

namespace App\Exports;

use App\Models\Deviasi;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View as ViewContract;

class PenyerapanDetailExport implements FromView, WithStyles, WithTitle, ShouldAutoSize
{
    protected $penyerapan;
    protected $data;
    protected $cumulativeData;
    protected $totals;

    public function __construct($id)
    {
        $this->penyerapan = Deviasi::with(['skpd', 'detail' => function($query) {
            $query->orderBy('id', 'asc');
        }])->find($id);
        
        $this->data = $this->penyerapan;
        
        // Pre-compute cumulative values to avoid N+1 queries
        $details = $this->data->detail;
        $this->cumulativeData = [];

        foreach ($details as $index => $detail) {
            // Get all details up to current index for cumulative calculations
            $previousDetails = $details->slice(0, $index + 1);

            $this->cumulativeData[$detail->id] = [
                'rak_komulatif_51' => $previousDetails->sum('kolom_c'),
                'rak_komulatif_52' => $previousDetails->sum('kolom_d'),
                'rak_komulatif_53' => $previousDetails->sum('kolom_e'),
                'rak_komulatif_54' => $previousDetails->sum('kolom_f'),
                'rak_komulatif_kb' => $previousDetails->sum(function ($item) {
                    return $item->kolom_c + $item->kolom_d + $item->kolom_e + $item->kolom_f;
                }),
                'rak_realisasi_51' => $previousDetails->sum('kolom_g'),
                'rak_realisasi_52' => $previousDetails->sum('kolom_h'),
                'rak_realisasi_53' => $previousDetails->sum('kolom_i'),
                'rak_realisasi_54' => $previousDetails->sum('kolom_j'),
                'rak_realisasi_kb' => $previousDetails->sum(function ($item) {
                    return $item->kolom_g + $item->kolom_h + $item->kolom_i + $item->kolom_j;
                }),
                'akumulasi_deviasi' => $previousDetails->sum(function ($item) {
                    return $item->seluruhDeviasi();
                }),
            ];

            // Calculate penyerapan anggaran
            $totalPagu = $this->data->totalPagu();
            $this->cumulativeData[$detail->id]['penyerapan_anggaran'] = $totalPagu > 0
                ? ($this->cumulativeData[$detail->id]['rak_realisasi_kb'] / $totalPagu) * 100
                : 0;
        }
        
        // Pre-compute totals for summary row
        $this->totals = [
            'kolom_c' => $details->sum('kolom_c'),
            'kolom_d' => $details->sum('kolom_d'),
            'kolom_e' => $details->sum('kolom_e'),
            'kolom_f' => $details->sum('kolom_f'),
            'kolom_g' => $details->sum('kolom_g'),
            'kolom_h' => $details->sum('kolom_h'),
            'kolom_i' => $details->sum('kolom_i'),
            'kolom_j' => $details->sum('kolom_j'),
        ];
    }

    public function view(): ViewContract
    {
        return view('exports.penyerapan_detail', [
            'data' => $this->data,
            'cumulativeData' => $this->cumulativeData,
            'totals' => $this->totals,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style for header rows
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFFF00']
                ]
            ],
            3 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFFF00']
                ]
            ],
            // Style for summary rows
            'A17:T17' => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFE4B5']
                ]
            ],
            // Style for all borders
            'A1:T17' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Penyerapan Anggaran - ' . $this->data->skpd->nama . ' - ' . $this->data->tahun;
    }
}
