<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $appointments = collect(); // Initialize with an empty collection to handle non-patient/non-doctor users
        $type = '';

        if ($user->type === 'patient') {
            $appointments = Appointment::leftJoin('consultations', 'appointments.id', '=', 'consultations.appointment_id')
                ->where('appointments.email', $user->email)
                ->orderBy('appointments.date')
                ->orderBy('appointments.time')
                ->get();
            $type = 'patient';
        } elseif ($user->type === 'doctor') {
            $appointments = Appointment::leftJoin('consultations', 'appointments.id', '=', 'consultations.appointment_id')
                ->select('appointments.*')
                ->whereNull('consultations.id')
                ->orderBy('appointments.date')
                ->orderBy('appointments.time')
                ->get();
            $type = 'doctor';
        } 
        
        return view('dashboard', ['appointments' => $appointments, 'type' => $type]);
    }
}
