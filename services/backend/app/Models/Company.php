<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'favorite',
        'url',
        'login',
        'note',
    ];

    public function selections() 
    {
        return $this->hasOne(Selection::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }
}
