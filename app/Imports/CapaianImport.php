<?php

namespace App\Imports;

use App\Models\CapaianDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CapaianImport implements ToModel, WithStartRow
{
    /**
     * @param Collection $collection
     */
    protected $skpd_id;
    protected $capaian;
    protected $tahun;

    public function __construct($tahun, $skpd_id, $capaian)
    {
        $this->tahun = $tahun;
        $this->skpd_id = $skpd_id;
        $this->capaian = $capaian;
    }

    public function model(array $row)
    {
        // Parse dan clean data
        $kolom_a = trim($row[2] ?? '');
        $kolom_b = trim($row[3] ?? '');
        $kolom_c = trim($row[4] ?? '');
        $kolom_d = trim($row[5] ?? '');
        $kolom_e = trim($row[6] ?? '');
        $kolom_f = trim($row[7] ?? '');
        $kolom_g = trim($row[8] ?? '');
        $kolom_h = trim($row[9] ?? '');
        $kolom_i = trim($row[10] ?? '');
        $kolom_j = trim($row[11] ?? '');
        $kolom_k = trim($row[12] ?? '');
        $kolom_l = trim($row[13] ?? '');
        $kolom_m = trim($row[14] ?? '');
        $kolom_n = trim($row[15] ?? '');
        $kolom_o = trim($row[16] ?? '');

        // Validasi komprehensif: skip jika tidak ada data yang valid
        $hasValidData = false;

        // Cek semua kolom untuk data yang valid
        $columns = [
            $kolom_a,
            $kolom_b,
            $kolom_c,
            $kolom_d,
            $kolom_e,
            $kolom_f,
            $kolom_g,
            $kolom_h,
            $kolom_i,
            $kolom_j,
            $kolom_k,
            $kolom_l,
            $kolom_m,
            $kolom_n,
            $kolom_o
        ];

        foreach ($columns as $column) {
            if (!empty($column)) {
                $hasValidData = true;
                break;
            }
        }

        // Jika tidak ada data valid, skip row ini
        if (!$hasValidData) {
            return null;
        }

        return new CapaianDetail([
            'tahun' => $this->tahun,
            'skpd_id' => $this->skpd_id,
            'capaian_id' => $this->capaian->id,
            'kolom_a' => $kolom_a,
            'kolom_b' => $kolom_b,
            'kolom_c' => $kolom_c,
            'kolom_d' => $kolom_d,
            'kolom_e' => $kolom_e,
            'kolom_f' => $kolom_f,
            'kolom_g' => $kolom_g,
            'kolom_h' => $kolom_h,
            'kolom_i' => $kolom_i,
            'kolom_j' => $kolom_j,
            'kolom_k' => $kolom_k,
            'kolom_l' => $kolom_l,
            'kolom_m' => $kolom_m,
            'kolom_n' => $kolom_n,
            'kolom_o' => $kolom_o,
        ]);
    }
    public function startRow(): int
    {
        return 7;
    }
}
