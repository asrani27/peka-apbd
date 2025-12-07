<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianDetail extends Model
{
    protected $table = 'capaian_detail';
    protected $guarded = ['id'];

    /**
     * Calculate percentage for Target Volume TW I
     * Formula: (kolom_h / kolom_f) * 100
     */
    public function getPersentaseTargetTw1Attribute()
    {
        if ($this->kolom_f == 0) {
            return 0;
        }
        return ($this->kolom_h / $this->kolom_f) * 100;
    }

    /**
     * Calculate percentage for Target Volume TW II
     * Formula: (kolom_i / kolom_f) * 100
     */
    public function getPersentaseTargetTw2Attribute()
    {
        if ($this->kolom_f == 0) {
            return 0;
        }
        return ($this->kolom_i / $this->kolom_f) * 100;
    }

    /**
     * Calculate percentage for Target Volume TW III
     * Formula: (kolom_j / kolom_f) * 100
     */
    public function getPersentaseTargetTw3Attribute()
    {
        if ($this->kolom_f == 0) {
            return 0;
        }
        return ($this->kolom_j / $this->kolom_f) * 100;
    }

    /**
     * Calculate percentage for Target Volume TW IV
     * Formula: (kolom_k / kolom_f) * 100
     */
    public function getPersentaseTargetTw4Attribute()
    {
        if ($this->kolom_f == 0) {
            return 0;
        }
        return ($this->kolom_k / $this->kolom_f) * 100;
    }

    /**
     * Get formatted percentage for Target Volume TW I
     */
    public function getPersentaseTargetTw1FormattedAttribute()
    {
        return number_format($this->persentase_target_tw1, 2) . '%';
    }

    /**
     * Get formatted percentage for Target Volume TW II
     */
    public function getPersentaseTargetTw2FormattedAttribute()
    {
        return number_format($this->persentase_target_tw2, 2) . '%';
    }

    /**
     * Get formatted percentage for Target Volume TW III
     */
    public function getPersentaseTargetTw3FormattedAttribute()
    {
        return number_format($this->persentase_target_tw3, 2) . '%';
    }

    /**
     * Get formatted percentage for Target Volume TW IV
     */
    public function getPersentaseTargetTw4FormattedAttribute()
    {
        return number_format($this->persentase_target_tw4, 2) . '%';
    }

    /**
     * Calculate percentage for Capaian Volume TW I
     * Formula: (kolom_l / kolom_f) * 100
     */
    public function getPersentaseCapaianTw1Attribute()
    {
        if ($this->kolom_f == 0) {
            return 0;
        }

        return ($this->kolom_l / $this->kolom_f) * 100;
    }

    /**
     * Calculate percentage for Capaian Volume TW II
     * Formula: (kolom_m / kolom_f) * 100
     */
    public function getPersentaseCapaianTw2Attribute()
    {
        if ($this->kolom_f == 0) {
            return 0;
        }
        return ($this->kolom_m / $this->kolom_f) * 100;
    }

    /**
     * Calculate percentage for Capaian Volume TW III
     * Formula: (kolom_n / kolom_f) * 100
     */
    public function getPersentaseCapaianTw3Attribute()
    {
        if ($this->kolom_f == 0) {
            return 0;
        }
        return ($this->kolom_n / $this->kolom_f) * 100;
    }

    /**
     * Calculate percentage for Capaian Volume TW IV
     * Formula: (kolom_o / kolom_f) * 100
     */
    public function getPersentaseCapaianTw4Attribute()
    {
        if ($this->kolom_f == 0) {
            return 0;
        }
        return ($this->kolom_o / $this->kolom_f) * 100;
    }

    /**
     * Get formatted percentage for Capaian Volume TW I
     */
    public function getPersentaseCapaianTw1FormattedAttribute()
    {
        return number_format($this->persentase_capaian_tw1, 2) . '%';
    }

    /**
     * Get formatted percentage for Capaian Volume TW II
     */
    public function getPersentaseCapaianTw2FormattedAttribute()
    {
        return number_format($this->persentase_capaian_tw2, 2) . '%';
    }

    /**
     * Get formatted percentage for Capaian Volume TW III
     */
    public function getPersentaseCapaianTw3FormattedAttribute()
    {
        return number_format($this->persentase_capaian_tw3, 2) . '%';
    }

    /**
     * Get formatted percentage for Capaian Volume TW IV
     */
    public function getPersentaseCapaianTw4FormattedAttribute()
    {
        return number_format($this->persentase_capaian_tw4, 2) . '%';
    }

    /**
     * Calculate Nilai Capaian TW I
     * Formula: (persentase_capaian_tw1 / persentase_target_tw1) * 100
     * Only if target > 0, otherwise empty
     */
    public function getNilaiCapaianTw1Attribute()
    {
        if ($this->kolom_h == 0 || $this->persentase_target_tw1 == 0) {
            return null;
        }
        return ($this->persentase_capaian_tw1 / $this->persentase_target_tw1) * 100;
    }

    /**
     * Calculate Nilai Capaian TW II
     * Formula: (persentase_capaian_tw2 / persentase_target_tw2) * 100
     * Only if target > 0, otherwise empty
     */
    public function getNilaiCapaianTw2Attribute()
    {
        if ($this->kolom_i == 0 || $this->persentase_target_tw2 == 0) {
            return null;
        }
        return ($this->persentase_capaian_tw2 / $this->persentase_target_tw2) * 100;
    }

    /**
     * Calculate Nilai Capaian TW III
     * Formula: (persentase_capaian_tw3 / persentase_target_tw3) * 100
     * Only if target > 0, otherwise empty
     */
    public function getNilaiCapaianTw3Attribute()
    {
        if ($this->kolom_j == 0 || $this->persentase_target_tw3 == 0) {
            return null;
        }
        return ($this->persentase_capaian_tw3 / $this->persentase_target_tw3) * 100;
    }

    /**
     * Calculate Nilai Capaian TW IV
     * Formula: (persentase_capaian_tw4 / persentase_target_tw4) * 100
     * Only if target > 0, otherwise empty
     */
    public function getNilaiCapaianTw4Attribute()
    {
        if ($this->kolom_k == 0 || $this->persentase_target_tw4 == 0) {
            return null;
        }
        return ($this->persentase_capaian_tw4 / $this->persentase_target_tw4) * 100;
    }

    /**
     * Get formatted Nilai Capaian TW I
     */
    public function getNilaiCapaianTw1FormattedAttribute()
    {
        if ($this->nilai_capaian_tw1 === null) {
            return '';
        }
        return number_format($this->nilai_capaian_tw1, 2);
    }

    /**
     * Get formatted Nilai Capaian TW II
     */
    public function getNilaiCapaianTw2FormattedAttribute()
    {
        if ($this->nilai_capaian_tw2 === null) {
            return '';
        }
        return number_format($this->nilai_capaian_tw2, 2);
    }

    /**
     * Get formatted Nilai Capaian TW III
     */
    public function getNilaiCapaianTw3FormattedAttribute()
    {
        if ($this->nilai_capaian_tw3 === null) {
            return '';
        }
        return number_format($this->nilai_capaian_tw3, 2);
    }

    /**
     * Get formatted Nilai Capaian TW IV
     */
    public function getNilaiCapaianTw4FormattedAttribute()
    {
        if ($this->nilai_capaian_tw4 === null) {
            return '';
        }
        return number_format($this->nilai_capaian_tw4, 2);
    }

    /**
     * Calculate Nilai Capaian Maksimal TW I (Max 100)
     * Formula: min(nilai_capaian_tw1, 100)
     * Only if nilai_capaian_tw1 exists, otherwise empty
     */
    public function getNilaiCapaianMaksimalTw1Attribute()
    {
        if ($this->nilai_capaian_tw1 === null) {
            return null;
        }
        return min($this->nilai_capaian_tw1, 100);
    }

    /**
     * Calculate Nilai Capaian Maksimal TW II (Max 100)
     * Formula: min(nilai_capaian_tw2, 100)
     * Only if nilai_capaian_tw2 exists, otherwise empty
     */
    public function getNilaiCapaianMaksimalTw2Attribute()
    {
        if ($this->nilai_capaian_tw2 === null) {
            return null;
        }
        return min($this->nilai_capaian_tw2, 100);
    }

    /**
     * Calculate Nilai Capaian Maksimal TW III (Max 100)
     * Formula: min(nilai_capaian_tw3, 100)
     * Only if nilai_capaian_tw3 exists, otherwise empty
     */
    public function getNilaiCapaianMaksimalTw3Attribute()
    {
        if ($this->nilai_capaian_tw3 === null) {
            return null;
        }
        return min($this->nilai_capaian_tw3, 100);
    }

    /**
     * Calculate Nilai Capaian Maksimal TW IV (Max 100)
     * Formula: min(nilai_capaian_tw4, 100)
     * Only if nilai_capaian_tw4 exists, otherwise empty
     */
    public function getNilaiCapaianMaksimalTw4Attribute()
    {
        if ($this->nilai_capaian_tw4 === null) {
            return null;
        }
        return min($this->nilai_capaian_tw4, 100);
    }

    /**
     * Get formatted Nilai Capaian Maksimal TW I
     */
    public function getNilaiCapaianMaksimalTw1FormattedAttribute()
    {
        if ($this->nilai_capaian_maksimal_tw1 === null) {
            return '';
        }
        return number_format($this->nilai_capaian_maksimal_tw1, 2);
    }

    /**
     * Get formatted Nilai Capaian Maksimal TW II
     */
    public function getNilaiCapaianMaksimalTw2FormattedAttribute()
    {
        if ($this->nilai_capaian_maksimal_tw2 === null) {
            return '';
        }
        return number_format($this->nilai_capaian_maksimal_tw2, 2);
    }

    /**
     * Get formatted Nilai Capaian Maksimal TW III
     */
    public function getNilaiCapaianMaksimalTw3FormattedAttribute()
    {
        if ($this->nilai_capaian_maksimal_tw3 === null) {
            return '';
        }
        return number_format($this->nilai_capaian_maksimal_tw3, 2);
    }

    /**
     * Get formatted Nilai Capaian Maksimal TW IV
     */
    public function getNilaiCapaianMaksimalTw4FormattedAttribute()
    {
        if ($this->nilai_capaian_maksimal_tw4 === null) {
            return '';
        }
        return number_format($this->nilai_capaian_maksimal_tw4, 2);
    }
}
