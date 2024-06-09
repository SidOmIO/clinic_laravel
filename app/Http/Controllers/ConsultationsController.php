<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Appointment;
use App\Models\Medication;
use App\Models\Prescription;
use App\Models\AdminLog;
use App\Services\EmailService;

class ConsultationsController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index() {
    if (Auth::user()->type == "patient") {
        $consultations = Consultation::Join('appointments', 'appointments.id', '=', 'consultations.appointment_id')
                        ->where('patient_email', Auth::user()->email)
                        ->select('appointments.id as appointment_id', 'appointments.title', 'appointments.date', 'appointments.time', 'consultations.id as cid', 'consultations.remark', 'consultations.appointment_id')
                        ->get();
    } else {
        $consultations = Appointment::leftJoin('consultations', 'appointments.id', '=', 'consultations.appointment_id')
                        ->select('appointments.id', 'appointments.email', 'appointments.title', 'appointments.date', 'appointments.time', 'consultations.id as cid', 'consultations.remark', 'consultations.appointment_id')
                        ->get();
    }

    return view('consultations.index', compact('consultations'));
    }

    public function remark(Request $request)
    {
        $id = $request->query('id');
        $email = $request->query('email');
        $medications = Medication::all()->map(function ($medication) {
            return [
                'value' => $medication->id . '|' . $medication->price,
                'text' => $medication->name,
                'price' => $medication->price
            ];
        });

        return view('consultations.remark', ['medications' => $medications, 'appointment_id' => $id, 'patient_email' => $email]);
    }
    
    public function storeRemark(Request $request)
    {
        $doctor_email = Auth::user()->email;
        $patient_email = $request->input('patient_email');
        $appointment_id = $request->input('appointment_id');
        $remark = $request->input('remark');
        $medications = $request->input('medication');
        $quantities = $request->input('quantity');
        $total_price = 0;

        DB::beginTransaction();

        try {
            $consultation = Consultation::create([
                'appointment_id' => $appointment_id,
                'patient_email' => $patient_email,
                'doctor_email' => $doctor_email,
                'remark' => $remark,
                'total_price' => $total_price,
            ]);

            AdminLog::create([
                'action_type' => 'add_consultation',
                'email' => $doctor_email,
                'timestamp' => now(),
            ]);

            foreach ($medications as $index => $record) {
                list($medication, $price) = explode('|', $record);
                $quantity = $quantities[$index];
                $total_price += $price * $quantity;

                Prescription::create([
                    'consultation_id' => $consultation->id,
                    'medication_id' => $medication,
                    'quantity' => $quantity,
                ]);
            }

            $consultation->update(['total_price' => $total_price]);

            DB::commit();

            $this->emailService->sendEmail($patient_email, 'email.consultation_title', 'email.consultation_body');
            return redirect()->route('consultations')->with('success', 'Remarks added successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error processing request: ' . $e->getMessage()]);
        }
    }

    public function details(Request $request) {
        $id = $request->query('id');
        $consultation = Consultation::findOrFail($id);

        $prescriptions = Prescription::join('medications', 'prescriptions.id', '=', 'medications.id')
        ->where('consultation_id', $consultation->id)
        ->get();

        return view('consultations.details', [
            'consultation' => $consultation,
            'prescriptions' => $prescriptions,
        ]);
    }
}