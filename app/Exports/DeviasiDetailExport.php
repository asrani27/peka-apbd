<?php

namespace App\Exports;

use App\Models\Deviasi;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View as ViewContract;

class DeviasiDetailExport implements FromView, WithStyles, WithTitle, ShouldAutoSize
{
    protected $deviasi;
    protected $data;
    protected $cumulativeData;
    protected $totals;
    protected $proporsiPagu;
    protected $totalPagu;

    public function __construct($id)
    {
        $this->deviasi = Deviasi::with(['skpd', 'detail' => function($query) {
            $query->orderBy('id', 'asc');
        }])->find($id);
        
        $this->data = $this->deviasi;
        
        // Pre-compute all values to avoid N+1 queries
        $details = $this->data->detail;
        $this->cumulativeData = [];
        
        // Pre-compute proporsi pagu values once
        $this->proporsiPagu = [
            'RAK51' => $this->data->proporsiPaguRAK51(),
            'RAK52' => $this->data->proporsiPaguRAK52(),
            'RAK53' => $this->data->proporsiPaguRAK53(),
            'RAK54' => $this->data->proporsiPaguRAK54(),
            'Total' => $this->data->totalProporsiPagu(),
        ];
        
        foreach ($details as $index => $detail) {
            // Get all details up to current index for cumulative calculations
            $previousDetails = $details->slice(0, $index + 1);
            
            $this->cumulativeData[$detail->id] = [
                'deviasi_51' => $detail->deviasi51(),
                'deviasi_52' => $detail->deviasi52(),
                'deviasi_53' => $detail->deviasi53(),
                'deviasi_54' => $detail->deviasi54(),
                'koreksi_51' => $detail->koreksi51(),
                'koreksi_52' => $detail->koreksi52(),
                'koreksi_53' => $detail->koreksi53(),
                'koreksi_54' => $detail->koreksi54(),
                'deviasi_tertimbang_51' => $detail->deviasiTertimbang51(),
                'deviasi_tertimbang_52' => $detail->deviasiTertimbang52(),
                'deviasi_tertimbang_53' => $detail->deviasiTertimbang53(),
                'deviasi_tertimbang_54' => $detail->deviasiTertimbang54(),
                'seluruh_deviasi' => $detail->seluruhDeviasi(),
                'akumulasi_deviasi' => $previousDetails->sum(function($item) {
                    return $item->seluruhDeviasi();
                }),
                'deviasi_rata_rata' => 0, // Will be calculated below
                'nilai_ikpa' => 0, // Will be calculated below
            ];
            
            // Calculate deviasi rata-rata
            $bulanAngka = $detail->bulanKeAngka($detail->bulan);
            $this->cumulativeData[$detail->id]['deviasi_rata_rata'] = $bulanAngka > 0 
                ? ($this->cumulativeData[$detail->id]['akumulasi_deviasi'] / $bulanAngka) 
                : 0;
            
            // Calculate nilai IKPA
            $deviasiRataRata = $this->cumulativeData[$detail->id]['deviasi_rata_rata'];
            $this->cumulativeData[$detail->id]['nilai_ikpa'] = ($deviasiRataRata <= 15) ? 100 : (100 - $deviasiRataRata);
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
        
        // Pre-compute total pagu
        $this->totalPagu = $this->data->totalPagu();
    }

    public function view(): ViewContract
    {
        return view('exports.deviasi_detail', [
            'data' => $this->data,
            'cumulativeData' => $this->cumulativeData,
            'totals' => $this->totals,
            'proporsiPagu' => $this->proporsiPagu,
            'totalPagu' => $this->totalPagu,
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
            'A14:J16' => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFE4B5']
                ]
            ],
            // Style for all borders
            'A1:J16' => [
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
        return 'Deviasi DPA - ' . $this->data->skpd->nama . ' - ' . $this->data->tahun;
    }
}
