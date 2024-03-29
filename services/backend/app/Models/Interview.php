<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'times',
        'interview',
        'note',
        'result',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
