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
        if (empty($row[2]) || trim($row[2]) === '') {
            return null;
        }

        return new CapaianDetail([
            'tahun' => $this->tahun,
            'skpd_id' => $this->skpd_id,
            'capaian_id' => $this->capaian->id,

            'kolom_a' => $row[2],
            'kolom_b' => $row[3],
            'kolom_c' => $row[4],
            'kolom_d' => $row[5],
            'kolom_e' => $row[6],
            'kolom_f' => $row[7],
            'kolom_g' => $row[8],
            'kolom_h' => $row[9],
            'kolom_i' => $row[10],
            'kolom_j' => $row[11],
            'kolom_k' => $row[12],
            'kolom_l' => $row[13],
            'kolom_m' => $row[14],
            'kolom_n' => $row[15],
            'kolom_o' => $row[16],
        ]);
    }
    public function startRow(): int
    {
        return 7;
    }
}
