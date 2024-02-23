<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'es',
        'es_note',
        'es_result',
        'test',
        'test_type',
        'test_note',
        'test_result',
        'gd',
        'gd_note',
        'gd_result',
        'result',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
