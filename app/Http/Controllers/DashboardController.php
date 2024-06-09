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
        $appointments = collect();
        $type = $user->type;
        $nextAppointment = null;
        $paymentPending = [];

        if ($type === 'patient') {
            $appointments = $this->getPatientAppointments($user->email);
            $nextAppointment = $this->getNextAppointment($appointments);
            $paymentPending = $this->getPaymentPending($appointments);
        } elseif ($type === 'doctor') {
            $appointments = $this->getDoctorAppointments();
        }

        return view('dashboard', [
            'appointments' => $appointments, 
            'type' => $type, 
            'nextAppointment' => $nextAppointment, 
            'paymentPending' => $paymentPending
        ]);
    }

    private function getPatientAppointments($email)
    {
        return Appointment::leftJoin('consultations', 'appointments.id', '=', 'consultations.appointment_id')
            ->where('appointments.email', $email)
            ->orderBy('appointments.date')
            ->orderBy('appointments.time')
            ->get();
    }

    private function getDoctorAppointments()
    {
        return Appointment::leftJoin('consultations', 'appointments.id', '=', 'consultations.appointment_id')
            ->select('appointments.*')
            ->whereNull('consultations.id')
            ->orderBy('appointments.date')
            ->orderBy('appointments.time')
            ->get();
    }

    private function getNextAppointment($appointments)
    {
        $nextAppointment = null;
        foreach ($appointments as $appointment) {
            if (is_null($appointment->id) && (is_null($nextAppointment) || strtotime($appointment->date) < strtotime($nextAppointment->date))) {
                $nextAppointment = $appointment;
            }
        }
        return $nextAppointment;
    }

    private function getPaymentPending($appointments)
    {
        return $appointments->filter(function($appointment) {
            return !is_null($appointment->id) && is_null($appointment->payment_id);
        });
    }
}
