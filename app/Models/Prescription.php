<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'consultation_id',
        'medication_id',
        'quantity',
    ];
}
