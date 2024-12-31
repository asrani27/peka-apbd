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
}
