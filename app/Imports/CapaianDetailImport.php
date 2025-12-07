<?php

namespace App\Imports;

use App\Models\CapaianDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CapaianDetailImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $capaian_id;

    public function __construct($capaian_id)
    {
        $this->capaian_id = $capaian_id;
    }

    /**
     * Get capaian data to extract tahun and skpd_id
     */
    private function getCapaianData()
    {
        $capaian = \App\Models\Capaian::find($this->capaian_id);
        return $capaian ? ['tahun' => $capaian->tahun, 'skpd_id' => $capaian->skpd_id] : ['tahun' => null, 'skpd_id' => null];
    }

    public function model(array $row)
    {
        // Parse dan clean data sesuai mapping yang diminta
        $kolom_b = trim($row[3] ?? ''); // D7 = column D (index 3)
        $kolom_c = trim($row[4] ?? ''); // E7 = column E (index 4)
        $kolom_d = trim($row[5] ?? ''); // F7 = column F (index 5)
        $kolom_e = trim($row[6] ?? ''); // G7 = column G (index 6)
        $kolom_f = trim($row[7] ?? ''); // H7 = column H (index 7)
        $kolom_g = trim($row[8] ?? ''); // I7 = column I (index 8)
        $kolom_h = trim($row[9] ?? ''); // J7 = column J (index 9)
        $kolom_i = trim($row[10] ?? ''); // K7 = column K (index 10)
        $kolom_j = trim($row[11] ?? ''); // L7 = column L (index 11)
        $kolom_k = trim($row[12] ?? ''); // M7 = column M (index 12)
        $kolom_l = trim($row[13] ?? ''); // N7 = column N (index 13)
        $kolom_m = trim($row[14] ?? ''); // O7 = column O (index 14)
        $kolom_n = trim($row[15] ?? ''); // P7 = column P (index 15)
        $kolom_o = trim($row[16] ?? ''); // Q7 = column Q (index 16)

        // Validasi komprehensif: skip jika tidak ada data yang valid
        $hasValidData = false;

        // Cek semua kolom untuk data yang valid
        $columns = [
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

        // Get capaian data for tahun and skpd_id
        $capaianData = $this->getCapaianData();

        // Konversi data untuk kolom yang seharusnya numerik (hingga o)
        $data = [
            'tahun' => $capaianData['tahun'],
            'skpd_id' => $capaianData['skpd_id'],
            'capaian_id' => $this->capaian_id,
            'kolom_a' => '', // Kosong karena tidak ada di mapping
            'kolom_b' => $kolom_b,
            'kolom_c' => $kolom_c,
            'kolom_d' => $kolom_d,
            'kolom_e' => $kolom_e,
            'kolom_f' => $kolom_f, // H7 = column H (index 7)
            'kolom_g' => $kolom_g,
        ];

        // Kolom h-o seharusnya numerik, konversi dengan aman
        $numericColumns = ['h', 'i', 'j', 'k', 'l', 'm', 'n', 'o'];
        foreach ($numericColumns as $col) {
            $value = ${'kolom_' . $col};

            // Jika value adalah string yang bukan angka, set ke 0
            if (is_numeric($value)) {
                $data['kolom_' . $col] = (float) $value;
            } elseif (!empty($value)) {
                // Untuk kolom l, m, n, o (sesuai feedback N, O, P, Q di Excel)
                // hapus karakter % dan non-numeric lainnya
                if (in_array($col, ['l', 'm', 'n', 'o'])) {
                    // Hapus % dan karakter non-numeric lainnya
                    $cleanedValue = str_replace('%', '', $value);
                    $numericValue = preg_replace('/[^0-9.-]/', '', $cleanedValue);
                    $data['kolom_' . $col] = is_numeric($numericValue) ? (float) $numericValue : 0;
                } else {
                    // Untuk kolom h-k, extract angka atau set ke 0
                    $numericValue = preg_replace('/[^0-9.-]/', '', $value);
                    $data['kolom_' . $col] = is_numeric($numericValue) ? (float) $numericValue : 0;
                }
            } else {
                $data['kolom_' . $col] = 0;
            }
        }

        return new CapaianDetail($data);
    }

    public function startRow(): int
    {
        return 7;
    }
}
