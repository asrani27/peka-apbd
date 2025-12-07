<?php

namespace App\Imports;

use App\Models\RevisiDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RevisiImport implements ToModel, WithStartRow
{
    protected $revisi_id;
    protected $currentRow = 0;

    public function __construct($revisi_id)
    {
        $this->revisi_id = $revisi_id;
    }

    public function model(array $row)
    {
        $this->currentRow++;
        $absoluteRow = $this->currentRow + 4; // karena startRow = 5

        // Skip baris 17-18 (baris kosong antara semester 1 dan 2)
        if ($absoluteRow >= 17 && $absoluteRow <= 18) {
            return null;
        }

        // Hanya proses baris yang sesuai dengan range yang ditentukan
        if (!(($absoluteRow >= 5 && $absoluteRow <= 16) || ($absoluteRow >= 19 && $absoluteRow <= 30))) {
            return null;
        }

        // Format tanggal jika ada
        $tanggal_nodin = $this->formatDate($row[2]);
        $tanggal_pengesahan = $this->formatDate($row[3]);

        // Parse data
        $revisi_ke = trim($row[4] ?? '');
        $jenis_revisi = trim($row[5] ?? '');
        $pagu_awal = $this->parseNumber($row[6]);
        $pagu_akhir = $this->parseNumber($row[7]);

        // Validasi komprehensif: skip jika tidak ada data yang valid
        $hasValidData = false;
        
        // Cek tanggal
        if (!empty($tanggal_nodin) || !empty($tanggal_pengesahan)) {
            $hasValidData = true;
        }
        
        // Cek revisi_ke (bukan string kosong atau hanya whitespace)
        if (!empty($revisi_ke)) {
            $hasValidData = true;
        }
        
        // Cek jenis_revisi (bukan string kosong atau hanya whitespace)
        if (!empty($jenis_revisi)) {
            $hasValidData = true;
        }
        
        // Cek pagu (nilai yang bukan 0 atau meaningful)
        if (!empty($pagu_awal) && $pagu_awal > 0) {
            $hasValidData = true;
        }
        
        if (!empty($pagu_akhir) && $pagu_akhir > 0) {
            $hasValidData = true;
        }

        // Jika tidak ada data valid, skip row ini
        if (!$hasValidData) {
            return null;
        }

        // Tentukan semester berdasarkan baris absolut
        // Semester 1: baris 5-16
        // Semester 2: baris 19-30
        $semester = 1; // default
        if ($absoluteRow >= 19 && $absoluteRow <= 30) {
            $semester = 2;
        }

        return new RevisiDetail([
            'revisi_id' => $this->revisi_id,
            'semester' => $semester,
            'tanggal_nodin' => $tanggal_nodin,
            'tanggal_pengesahan' => $tanggal_pengesahan,
            'revisi_ke' => $revisi_ke,
            'jenis_revisi' => $jenis_revisi,
            'pagu_awal' => $pagu_awal,
            'pagu_akhir' => $pagu_akhir,
        ]);
    }

    public function startRow(): int
    {
        return 5; // Mulai dari baris 5
    }

    private function formatDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Coba format Excel serial date
            if (is_numeric($date)) {
                $excelDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
                return $excelDate->format('Y-m-d');
            }

            // Coba format string date
            $dateObj = \DateTime::createFromFormat('d/m/Y', $date);
            if ($dateObj) {
                return $dateObj->format('Y-m-d');
            }

            // Coba format lainnya
            $dateObj = \DateTime::createFromFormat('Y-m-d', $date);
            if ($dateObj) {
                return $dateObj->format('Y-m-d');
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseNumber($value)
    {
        if (empty($value)) {
            return 0;
        }

        // Remove formatting seperti Rp. , dll
        $cleanValue = preg_replace('/[^0-9.,-]/', '', $value);
        $cleanValue = str_replace('.', '', $cleanValue);
        $cleanValue = str_replace(',', '.', $cleanValue);

        return (float) $cleanValue;
    }
}
