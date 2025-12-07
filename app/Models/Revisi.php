<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    protected $table = 'revisi';
    protected $guarded = ['id'];

    public function ikpa()
    {
        return $this->belongsTo(Ikpa::class);
    }
    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }
    public function revisiDetail()
    {
        return $this->hasMany(RevisiDetail::class);
    }

    public function details()
    {
        return $this->hasMany(RevisiDetail::class);
    }

    /**
     * Hitungan Kolom R per-detail:
     * apakah pagu_awal == pagu_akhir
     */
    public function hitungR($detail)
    {
        if ($detail->pagu_akhir === null || $detail->pagu_awal === null) {
            return null;
        }

        return $detail->pagu_awal == $detail->pagu_akhir ? "Tidak" : "Ya";
    }

    /**
     * Hitung Skor Revisi (rumus: IF(E12=1; U45; V45))
     * E = semester saat ini, U = NKRA semester1, V = NKRA Tahunan
     * Untuk sekarang, asumsikan kita menggunakan semester 1
     */
    public function getSkorRevisiAttribute()
    {
        // Asumsi semester saat ini adalah 1 (bisa disesuaikan jika ada parameter semester)
        $semester = 1;
        
        if ($semester == 1) {
            return $this->nkraSemester1();
        } else {
            return $this->nkraTahunan();
        }
    }

    /**
     * Hitung Skor IT (Skor * Bobot)
     * Bobot = 15% = 0.15
     */
    public function getSkorITAttribute()
    {
        $skor = $this->skor_revisi;
        $bobot = 0.15; // 15%
        
        return $skor * $bobot;
    }

    /**
     * Getter untuk Skor Revisi
     */
    public function skorRevisi()
    {
        return $this->getSkorRevisiAttribute();
    }

    /**
     * Getter untuk Skor IT
     */
    public function skorIT()
    {
        return $this->getSkorITAttribute();
    }

    /**
     * Hitung Skor Revisi per Semester
     * Rumus: =IF(E12=1; U45; V45)
     * Semester 1: NKRA Semester 1
     * Semester 2: NKRA Tahunan
     */
    public function getSkorRevisiSemesterAttribute($semester)
    {
        if ($semester == 1) {
            return $this->nkraSemester1();
        } elseif ($semester == 2) {
            return $this->nkraTahunan();
        }
        
        return 0;
    }

    /**
     * Hitung Skor IT per Semester
     * Skor × Bobot (15%)
     */
    public function getSkorITSemesterAttribute($semester)
    {
        $skor = $this->getSkorRevisiSemesterAttribute($semester);
        $bobot = 0.15; // 15%
        
        return $skor * $bobot;
    }

    /**
     * Getter untuk Skor Revisi Semester 1
     */
    public function skorRevisiSemester1()
    {
        return $this->getSkorRevisiSemesterAttribute(1);
    }

    /**
     * Getter untuk Skor Revisi Semester 2
     */
    public function skorRevisiSemester2()
    {
        return $this->getSkorRevisiSemesterAttribute(2);
    }

    /**
     * Getter untuk Skor IT Semester 1
     */
    public function skorITSemester1()
    {
        return $this->getSkorITSemesterAttribute(1);
    }

    /**
     * Getter untuk Skor IT Semester 2
     */
    public function skorITSemester2()
    {
        return $this->getSkorITSemesterAttribute(2);
    }

    /**
     * Hitung Total Skor Revisi (Semester 1 + Semester 2)
     */
    public function getTotalSkorRevisiAttribute()
    {
        return $this->skorRevisiSemester1() + $this->skorRevisiSemester2();
    }

    /**
     * Hitung Total Skor IT (Semester 1 + Semester 2)
     */
    public function getTotalSkorITAttribute()
    {
        return $this->skorITSemester1() + $this->skorITSemester2();
    }

    /**
     * Getter untuk Total Skor Revisi
     */
    public function totalSkorRevisi()
    {
        return $this->getTotalSkorRevisiAttribute();
    }

    /**
     * Getter untuk Total Skor IT
     */
    public function totalSkorIT()
    {
        return $this->getTotalSkorITAttribute();
    }

    /**
     * Hitung T (jumlah nilai S yang "Ya")
     */
    public function hitungT()
    {
        $count = 0;

        foreach ($this->details as $detail) {
            $s = $this->hitungS($detail);
            if ($s === "Ya") {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Hitung nilai U berdasarkan T
     */
    public function hitungU()
    {
        $t = $this->hitungT();

        if ($t == 0) return 110;
        if ($t == 1) return 100;
        if ($t == 2) return 50;
        if ($t == 3) return 45;
        if ($t == 4) return 40;
        if ($t >= 5) return 35;

        return null;
    }

    /**
     * Kolom V = Nilai akhir revisi
     * (menggunakan U sebagai acuan lengkap)
     */
    public function getNilaiVAttribute()
    {
        return $this->hitungU();
    }

    /**
     * Hitung jumlah revisi per semester berdasarkan termasukObject
     * Rumus Excel: =IF(H5="";"";IF(H5="NA";0;COUNTIF(S5:S16;"Ya")))
     * S = termasukObject
     */
    public function jumlahRevisiPerSemester($semester)
    {
        if (!$this->revisiDetail || $this->revisiDetail->count() === 0) {
            return 0;
        }

        $count = 0;
        
        foreach ($this->revisiDetail as $detail) {
            if ($detail->semester == $semester) {
                $termasukObject = $detail->termasukObject();
                if ($termasukObject === "Ya") {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * Hitung jumlah revisi untuk semester 1
     */
    public function jumlahRevisiSemester1()
    {
        return $this->jumlahRevisiPerSemester(1);
    }

    /**
     * Hitung jumlah revisi untuk semester 2
     */
    public function jumlahRevisiSemester2()
    {
        return $this->jumlahRevisiPerSemester(2);
    }

    /**
     * Hitung NKRA per semester berdasarkan jumlah revisi
     * Rumus Excel: =IF(T5="";"";IF(T5=0;110;IF(T5=1;100;IF(T5=2;50;IF(T5=3;45;IF(T5=4;40;IF(T5>=5;35))))))
     * T = jumlah revisi per semester
     */
    public function nkraPerSemester($semester)
    {
        $jumlahRevisi = $this->jumlahRevisiPerSemester($semester);
        
        if ($jumlahRevisi == "") {
            return "";
        }
        
        if ($jumlahRevisi == 0) {
            return 110;
        } elseif ($jumlahRevisi == 1) {
            return 100;
        } elseif ($jumlahRevisi == 2) {
            return 50;
        } elseif ($jumlahRevisi == 3) {
            return 45;
        } elseif ($jumlahRevisi == 4) {
            return 40;
        } elseif ($jumlahRevisi >= 5) {
            return 35;
        }
        
        return null;
    }

    /**
     * Hitung NKRA untuk semester 1
     */
    public function nkraSemester1()
    {
        return $this->nkraPerSemester(1);
    }

    /**
     * Hitung NKRA untuk semester 2
     */
    public function nkraSemester2()
    {
        return $this->nkraPerSemester(2);
    }

    /**
     * Hitung NKRA tahunan
     * Rumus Excel: =IF(U19="";0,5*U5;((0,5*U5)+(0,5*U19)))
     * U5 = NKRA Semester 1, U19 = NKRA Semester 2
     */
    public function nkraTahunan()
    {
        $nkraSemester1 = $this->nkraSemester1();
        $nkraSemester2 = $this->nkraSemester2();
        
        // Jika semester 2 kosong, gunakan 50% dari semester 1
        if ($nkraSemester2 == "" || $nkraSemester2 === null) {
            return 0.5 * $nkraSemester1;
        }
        
        // Jika kedua semester ada, hitung rata-rata (50% + 50%)
        return (0.5 * $nkraSemester1) + (0.5 * $nkraSemester2);
    }
}
