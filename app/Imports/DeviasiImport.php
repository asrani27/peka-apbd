<?php

namespace App\Imports;

use App\Models\Deviasi;
use App\Models\DeviasiDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DeviasiImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $skpd_id;
    protected $deviasi;
    protected $tahun;
    protected $rowCount = 0; // Counter untuk membatasi jumlah baris
    protected $maxRows = 12; // Karena start dari baris 7, batas 18 - 7 + 1 = 12 baris

    public function __construct($tahun, $skpd_id, $deviasi)
    {
        $this->tahun = $tahun;
        $this->skpd_id = $skpd_id;
        $this->deviasi = $deviasi;
    }

    public function model(array $row)
    {
        // Jika sudah melebihi batas baris yang ditentukan, hentikan import
        if ($this->rowCount >= $this->maxRows) {
            return null;
        }
        $this->rowCount++; // Tambahkan counter setiap kali baris diproses

        return new DeviasiDetail([
            'tahun' => $this->tahun,
            'skpd_id' => $this->skpd_id,
            'deviasi_id' => $this->deviasi->id,
            'bulan' => $row[1],
            'kolom_c' => $row[2],
            'kolom_d' => $row[3],
            'kolom_e' => $row[4],
            'kolom_f' => $row[5],
            'kolom_g' => $row[6],
            'kolom_h' => $row[7],
            'kolom_i' => $row[8],
            'kolom_j' => $row[9],
        ]);
    }
    public function startRow(): int
    {
        return 7;
    }
}
