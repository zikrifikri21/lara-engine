<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelUser extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function hakAkses()
    {
        return $this->hasMany('App\Models\HakAkses');
    }
}