<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;
use App\Services\EmailService;

class AppointmentsController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index()
    {
        if (Auth::user()->type == "admin") {
            $appointments = Appointment::leftJoin('consultations', 'consultations.appointment_id', '=', 'appointments.id')
                ->select('appointments.*', 'consultations.id as consultation_id')
                ->get();
        } else {
            $appointments = Appointment::where('email', Auth::user()->email)
                ->leftJoin('consultations', 'consultations.appointment_id', '=', 'appointments.id')
                ->select('appointments.*', 'consultations.id as consultation_id')
                ->get();
        }

        return view('appointments.index', compact('appointments'));
    }

    public function add()
    {
        return view('appointments.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'remark' => 'required|string',
        ]);

        $email = Auth::user()->email;
        $title = $request->title;
        $date = $request->date;
        $time = $request->time;
        $remark = $request->remark;

        $appointment = new Appointment();
        $appointment->email = $email;
        $appointment->title = $title;
        $appointment->date = $date;
        $appointment->time = $time;
        $appointment->remark = $remark;
        $appointment->save();

        $log = new AdminLog();
        $log->action_type = 'add_appointment';
        $log->email = $email;
        $log->created_at = now();
        $log->save();

        $this->emailService->sendEmail($email, 'email.add_appointment_title', 'email.add_appointment_body');

        return redirect()->route('appointments')->with('success', 'Appointment created successfully!');
    }

    public function edit($id)
    {
        $appointment = Appointment::find($id);
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'remark' => 'nullable'
        ]);

        $appointment = Appointment::find($request->id);
        $email = $appointment->email;
        $appointment->title = $request->title;
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->remark = $request->remark;
        $appointment->save();

        $log = new AdminLog();
        $log->action_type = 'update_appointment';
        $log->email = Auth::user()->email;
        $log->created_at = now();
        $log->save();

        $this->emailService->sendEmail($email, 'email.update_appointment_title', 'email.update_appointment_body');
        return redirect()->route('appointments')->with('success', 'Appointment updated successfully.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        $email = $appointment->email;
        $appointment->delete();

        $this->emailService->sendEmail($email, 'email.cancel_appointment_title', 'email.cancel_appointment_body');
        return redirect()->route('appointments')->with('error', 'Appointment deleted successfully.');
    }

    public function showConsultation($id)
    {
        $consultation = Consultation::find($id);
        return view('consultations.show', compact('consultation'));
    }
}
