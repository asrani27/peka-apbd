<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisiDetail extends Model
{
    protected $table = 'revisi_detail';
    protected $guarded = ['id'];

    public function revisi()
    {
        return $this->belongsTo(Revisi::class);
    }
    /**
     * Kolom R (perbandingan pagu_awal & pagu_akhir)
     */
    public function getNilaiRAttribute()
    {
        if ($this->pagu_akhir === "NA") {
            return "NA";
        }

        if ($this->pagu_awal === "" || $this->pagu_akhir === "") {
            return "";
        }

        return $this->pagu_awal == $this->pagu_akhir ? "Tidak" : "Ya";
    }

    /**
     * Perubahan Pagu (sesuai rumus Excel)
     * =IF(H5="NA";"NA";IF(G5="";"";IF(G5=H5;"Tidak";"Ya")))
     * G = pagu_awal, H = pagu_akhir
     */
    public function perubahanPagu()
    {
        // Jika pagu_akhir = "NA"
        if ($this->pagu_akhir == "NA" || $this->pagu_akhir === "NA") {
            return "NA";
        }

        // Jika pagu_awal kosong
        if (empty($this->pagu_awal) || $this->pagu_awal === "" || $this->pagu_awal === null) {
            return "";
        }

        // Jika pagu_awal = pagu_akhir
        if ($this->pagu_awal == $this->pagu_akhir) {
            return "Tidak";
        }

        // Jika pagu_awal != pagu_akhir
        return "Ya";
    }

    /**
     * Termasuk Object (sesuai rumus Excel)
     * =IF(R5="NA";"Tidak";IF(R5="";"";IF(R5="Ya";"Tidak";"Ya")))
     * R = perubahanPagu
     */
    public function termasukObject()
    {
        $perubahanPagu = $this->perubahanPagu();

        // Jika perubahanPagu = "NA"
        if ($perubahanPagu === "NA") {
            return "Tidak";
        }

        // Jika perubahanPagu kosong
        if ($perubahanPagu === "" || $perubahanPagu === null) {
            return "";
        }

        // Jika perubahanPagu = "Ya"
        if ($perubahanPagu === "Ya") {
            return "Tidak";
        }

        // Jika perubahanPagu = "Tidak"
        return "Ya";
    }

    /**
     * Kolom S (kebalikan dari R)
     */
    public function getNilaiSAttribute()
    {
        if ($this->nilai_r === "NA") return "Tidak";
        if ($this->nilai_r === "") return "";

        return $this->nilai_r === "Ya" ? "Tidak" : "Ya";
    }

    /**
     * Kolom U: scoring berdasarkan T (jumlah kesalahan / ketidaksesuaian)
     * 
     * T = jumlah nilai S = "Ya"
     * Untuk sekarang asumsi T = 1 per record
     * (bisa dimodifikasi jika nanti ada batch 12 baris seperti Excel)
     */
    public function getNilaiUAttribute()
    {
        // Contoh sederhana:
        $t = $this->nilai_s === "Ya" ? 1 : 0;

        if ($t === "") return null;
        if ($t == 0) return 110;
        if ($t == 1) return 100;
        if ($t == 2) return 50;
        if ($t == 3) return 45;
        if ($t == 4) return 40;

        return 35; // T >= 5
    }

    /**
     * Kolom V (gabungan U dan U19)
     * U19 = nilai U dari record dengan id ke-19 (atau bisa disesuaikan)
     */
    public function getNilaiVAttribute()
    {
        // Dapatkan nilai U19 (sesuaikan logika jika diperlukan)
        $u19 = self::find(19)?->nilai_u;

        // Jika U19 kosong → 0.5 * U saat ini
        if (empty($u19)) {
            return 0.5 * $this->nilai_u;
        }

        // Jika U19 ada → rata-rata 50%-50%
        return (0.5 * $this->nilai_u) + (0.5 * $u19);
    }
}
