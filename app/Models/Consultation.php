<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_email',
        'doctor_email',
        'remark',
        'total_price',
        'payment_id',
    ];
}
