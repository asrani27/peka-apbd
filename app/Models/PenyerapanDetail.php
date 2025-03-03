<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyerapanDetail extends Model
{
    protected $table = 'deviasi_detail';
    protected $guarded = ['id'];
    public function deviasi()
    {
        return $this->belongsTo(Deviasi::class);
    }
}
