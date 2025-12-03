<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ikpa extends Model
{
    protected $table = 'ikpa';
    protected $guarded = ['id'];

    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }
    public function revisi()
    {
        return $this->hasMany(Revisi::class, 'ikpa_id');
    }
    public function keberatan()
    {
        return $this->hasMany(Keberatan::class, 'ikpa_id');
    }
    public function jumlahRevisi($semester)
    {
        return $this->revisi
            ->where('semester', $semester)
            ->filter(fn($revisi) => $revisi->perubahanPagu() === 'Tidak')
            ->count();
    }

    public function nkra_semester($semester)
    {
        if ($this->jumlahRevisi($semester) === null || $this->jumlahRevisi($semester) === '') {
            return ''; // Jika kosong, return string kosong
        }

        return match ($this->jumlahRevisi($semester)) {
            0 => 110,
            1 => 100,
            2 => 50,
            3 => 45,
            4 => 40,
            default => ($this->jumlahRevisi($semester) >= 5 ? 35 : null),
        };
    }

    public function nkra_tahunan($semester1, $semester2)
    {
        if ($this->nkra_semester($semester2) === null || $this->nkra_semester($semester2) === '') {
            return 0.5 * $this->nkra_semester($semester1);
        }

        return (0.5 * $this->nkra_semester($semester1)) + (0.5 * $this->nkra_semester($semester2));
    }

    public function skorRevisi($semester)
    {
        return $semester == 1 ? $this->nkra_semester(1) : $this->nkra_tahunan(1, 2);
    }
    public function skorRevisiTertimbang($semester)
    {
        return round($this->skorRevisi($semester) * 15 / 100, 2);
    }
    public function skorDeviasi($tahun, $bulan)
    {
        // Convert month number to month name
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $bulanNama = $monthNames[$bulan] ?? $bulan;

        return optional(DeviasiDetail::where('tahun', $tahun)->where('bulan', $bulanNama)->first())->nilai_ikpa ?? 0;
    }
    public function skorDeviasiTertimbang($tahun, $bulan)
    {

        return round($this->skorDeviasi($tahun, $bulan) * 20 / 100, 2);
    }
    public function skorPenyerapan($tahun, $bulan)
    {
        // Convert month number to month name
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $bulanNama = $monthNames[$bulan] ?? $bulan;

        return optional(DeviasiDetail::where('tahun', $tahun)->where('bulan', $bulanNama)->first())->penyerapanAnggaran() ?? 0;
    }
    public function skorPenyerapanTertimbang($tahun, $bulan)
    {
        return round($this->skorPenyerapan($tahun, $bulan) * 30 / 100, 2);
    }
}
