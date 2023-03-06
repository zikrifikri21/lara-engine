<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }

    public function levelUser()
    {
        return $this->belongsTo('App\Models\LevelUser');
    }
}