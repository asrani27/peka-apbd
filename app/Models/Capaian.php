<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capaian extends Model
{
    protected $table = 'capaian';
    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasMany(CapaianDetail::class);
    }

    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }

    /**
     * Get total capaian for specific triwulan
     */
    public function getTotalCapaian($triwulan)
    {
        $field = "nilai_capaian_maksimal_tw{$triwulan}";
        return $this->detail->sum(function ($item) use ($field) {
            return $item->$field ?? 0;
        });
    }

    /**
     * Get count of output for specific triwulan
     */
    public function getCountOutput($triwulan)
    {
        $field = "nilai_capaian_maksimal_tw{$triwulan}";
        return $this->detail->filter(function ($item) use ($field) {
            $value = $item->$field;
            return $value !== null && $value >= 0 && $value !== '';
        })->count();
    }

    /**
     * Get average capaian for specific triwulan
     */
    public function getRataRataCapaian($triwulan)
    {
        $sum = $this->getTotalCapaian($triwulan);
        $count = $this->getCountOutput($triwulan);
        return $count > 0 ? $sum / $count : 0;
    }

    /**
     * Get koefisien penyesuaian for specific triwulan
     */
    public function getKoefisienPenyesuaian($triwulan)
    {
        $capaianField = "nilai_capaian_tw{$triwulan}";
        $maksimalField = "nilai_capaian_maksimal_tw{$triwulan}";

        $countLessThan100 = $this->detail->filter(function ($item) use ($capaianField) {
            $value = $item->$capaianField;
            return $value !== null && $value < 100 && $value !== '';
        })->count();

        $totalOutput = $this->detail->filter(function ($item) use ($maksimalField) {
            $value = $item->$maksimalField;
            return $value !== null && $value >= 0 && $value !== '';
        })->count();

        return $totalOutput > 0 ? ($countLessThan100 / $totalOutput) * 10 : 0;
    }

    /**
     * Get rata-rata capaian disesuaikan for specific triwulan
     */
    public function getRataRataCapaianDisesuaikan($triwulan)
    {
        $rataRata = $this->getRataRataCapaian($triwulan);
        $koefisien = $this->getKoefisienPenyesuaian($triwulan);
        return $rataRata - $koefisien;
    }

    /**
     * Get nilai ketepatan waktu for specific triwulan
     */
    public function getNilaiKetepatanWaktu($triwulan)
    {
        $periodeField = "periode_tw{$triwulan}";
        $periode = $this->$periodeField;
        
        // Formula: IF(D127="Ya"; 100; 0)
        // Jika periode = "Ya" maka 100, jika "Tidak" maka 0
        return ($periode === 'Ya') ? 100 : 0;
    }

    /**
     * Get summary data for all triwulans
     */
    public function getSummaryData()
    {
        $summary = [];
        
        for ($i = 1; $i <= 4; $i++) {
            $summary["total_capaian_tw{$i}"] = $this->getTotalCapaian($i);
            $summary["count_output_tw{$i}"] = $this->getCountOutput($i);
            $summary["rata_rata_tw{$i}"] = $this->getRataRataCapaian($i);
            $summary["koefisien_tw{$i}"] = $this->getKoefisienPenyesuaian($i);
            $summary["rata_rata_disesuaikan_tw{$i}"] = $this->getRataRataCapaianDisesuaikan($i);
            $summary["nilai_ketepatan_waktu_tw{$i}"] = $this->getNilaiKetepatanWaktu($i);
            $summary["nilai_capaian_output_tw{$i}"] = $this->getNilaiCapaianOutput($i);
            $summary["nilai_ketepatan_waktu_output_tw{$i}"] = $this->getNilaiKetepatanWaktuOutput($i);
            $summary["skor_indikator_tertimbang_tw{$i}"] = $this->getSkorIndikatorTertimbang($i);
        }
        
        return $summary;
    }

    /**
     * Get nilai capaian output for specific triwulan (akumulatif)
     */
    public function getNilaiCapaianOutput($triwulan)
    {
        $total = 0;
        for ($i = 1; $i <= $triwulan; $i++) {
            $rataRataDisesuaikan = $this->getRataRataCapaianDisesuaikan($i);
            $total += $rataRataDisesuaikan * 0.25;
        }
        return $total;
    }

    /**
     * Get nilai ketepatan waktu output for specific triwulan (akumulatif)
     */
    public function getNilaiKetepatanWaktuOutput($triwulan)
    {
        $total = 0;
        for ($i = 1; $i <= $triwulan; $i++) {
            $nilaiKetepatanWaktu = $this->getNilaiKetepatanWaktu($i);
            $total += $nilaiKetepatanWaktu * 0.25;
        }
        return $total;
    }

    /**
     * VLOOKUP function for capaian output scoring
     * Similar to Excel VLOOKUP(E13, R129:T132, 2, FALSE)
     */
    public function vlookupCapaianOutput($nilai)
    {
        // Tabel lookup untuk capaian output (R129:T132)
        $lookupTable = [
            ['min' => 0, 'max' => 50.99, 'skor' => 1],
            ['min' => 51, 'max' => 75.99, 'skor' => 2],
            ['min' => 76, 'max' => 90.99, 'skor' => 3],
            ['min' => 91, 'max' => 100, 'skor' => 4]
        ];

        foreach ($lookupTable as $row) {
            if ($nilai >= $row['min'] && $nilai <= $row['max']) {
                return $row['skor'];
            }
        }
        
        return 1; // Default jika tidak ada range yang cocok
    }

    /**
     * VLOOKUP function for ketepatan waktu scoring
     * Similar to Excel VLOOKUP for waktu values
     */
    public function vlookupKetepatanWaktu($nilai)
    {
        // Tabel lookup untuk ketepatan waktu
        $lookupTable = [
            ['min' => 0, 'max' => 50.99, 'skor' => 1],
            ['min' => 51, 'max' => 75.99, 'skor' => 2],
            ['min' => 76, 'max' => 90.99, 'skor' => 3],
            ['min' => 91, 'max' => 100, 'skor' => 4]
        ];

        foreach ($lookupTable as $row) {
            if ($nilai >= $row['min'] && $nilai <= $row['max']) {
                return $row['skor'];
            }
        }
        
        return 1; // Default jika tidak ada range yang cocok
    }

    /**
     * Get skor indikator tertimbang for specific triwulan
     */
    public function getSkorIndikatorTertimbang($triwulan)
    {
        $capaianOutput = $this->getNilaiCapaianOutput($triwulan);
        $ketepatanWaktu = $this->getNilaiKetepatanWaktuOutput($triwulan);
        
        $skorCapaian = $this->vlookupCapaianOutput($capaianOutput);
        $skorWaktu = $this->vlookupKetepatanWaktu($ketepatanWaktu);
        
        $bobotCapaian = $this->bobot_capaian ?? 0.70;
        $bobotWaktu = $this->bobot_ketepatan ?? 0.30;
        
        return ($skorCapaian * $bobotCapaian) + ($skorWaktu * $bobotWaktu);
    }

    /**
     * Get skor indikator tertimbang final for specific triwulan
     * Formula: (R×O) + (S×P) menggunakan nilai asli, bukan skor VLOOKUP
     */
    public function getSkorIndikatorTertimbangFinal($triwulan)
    {
        $summary = $this->getSummaryData();
        $capaianOutput = $summary["nilai_capaian_output_tw{$triwulan}"];
        $ketepatanWaktu = $summary["nilai_ketepatan_waktu_output_tw{$triwulan}"];
        
        $bobotCapaian = $this->bobot_capaian ?? 0.70;
        $bobotWaktu = $this->bobot_ketepatan ?? 0.30;
        
        return ($bobotCapaian * $capaianOutput) + ($bobotWaktu * $ketepatanWaktu);
    }

    /**
     * Get formula display for skor indikator tertimbang final
     */
    public function getFormulaSkorIndikatorTertimbang($triwulan)
    {
        $summary = $this->getSummaryData();
        $capaianOutput = $summary["nilai_capaian_output_tw{$triwulan}"];
        $ketepatanWaktu = $summary["nilai_ketepatan_waktu_output_tw{$triwulan}"];
        
        $bobotCapaian = $this->bobot_capaian ?? 0.70;
        $bobotWaktu = $this->bobot_ketepatan ?? 0.30;
        
        return number_format($bobotCapaian, 2) . '×' . number_format($capaianOutput, 2) . ' + ' . 
               number_format($bobotWaktu, 2) . '×' . number_format($ketepatanWaktu, 2);
    }

    /**
     * Get formatted skor indikator tertimbang final dengan 2 desimal
     */
    public function getFormattedSkorIndikatorTertimbang($triwulan)
    {
        $skor = $this->getSkorIndikatorTertimbangFinal($triwulan);
        return number_format($skor, 2);
    }

    /**
     * Get skor indikator tertimbang dengan bobot (35%)
     */
    public function getSkorIndikatorTertimbangDenganBobot($triwulan)
    {
        $skorFinal = $this->getSkorIndikatorTertimbangFinal($triwulan);
        return $skorFinal * 0.35;
    }

    /**
     * Get formatted skor indikator tertimbang dengan bobot (35%)
     */
    public function getFormattedSkorIndikatorTertimbangDenganBobot($triwulan)
    {
        $skorDenganBobot = $this->getSkorIndikatorTertimbangDenganBobot($triwulan);
        return number_format($skorDenganBobot, 2);
    }
}
