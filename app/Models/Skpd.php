<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    protected $table = 'skpd';
    protected $guarded = ['id'];

    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
