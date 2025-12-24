<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;

class LaporanExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    protected $rfkData;
    protected $semester;
    protected $tahun;
    protected $skpd;

    public function __construct($rfkData, $semester, $tahun, $skpd)
    {
        $this->rfkData = $rfkData;
        $this->semester = $semester;
        $this->tahun = $tahun;
        $this->skpd = $skpd;
    }

    public function view(): View
    {
        return view('exports.laporan', [
            'rfkData' => $this->rfkData,
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'skpd' => $this->skpd
        ]);
    }

    public function title(): string
    {
        return 'Laporan RAK ' . $this->skpd->nama . ' - ' . $this->tahun;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'FFC107'
                    ]
                ]
            ],
            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'FFC107'
                    ]
                ]
            ],
            // Style untuk total rows
            'A' => [
                'font' => [
                    'bold' => true
                ]
            ],
        ];
    }
}
