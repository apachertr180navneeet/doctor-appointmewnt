<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Appointment, Time};
use Illuminate\Support\Facades\{Session, Redirect, Validator, Storage, Log};
use Mail, Hash, File, DB, Helper, Auth;
use Carbon\Carbon;

class DoctorAppointmentController extends Controller
{
    //========================= Appointment Member Functions ========================//

    /**
     * Display a listing of the Appointment.
     */
    public function index()
    {
        $usersId = Auth::user()->id;
        // Retrieve all Appointment
        $appointments = Appointment::where('user_id', $usersId)->get();
        return view('doctor.appointment.index',compact('usersId','appointments'));
    }

    /**
     * Show the form for creating a new Appointment.
     */
    public function create()
    {
        return view('doctor.appointment.create');
    }

    /**
     * Store a newly created Appointment in the database.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'date' => 'required|unique:appointments,date,NULL,id,user_id,'.$request->userid,
            'time' => 'required'
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Appointment Created
        $appointment = Appointment::create([
            'user_id' => Auth::user()->id,
            'date' => $request->date
        ]);

        // Time Created
        foreach ($request->time as $time) {
            Time::create([
                'appointment_id' => $appointment->id,
                'time' => $time,
                //'status' => 0
            ]);
        }

        // Redirect with success message
        return redirect()->route('doctor.appointment.index')->with('success', 'Appointment created for '. $request->date);
    }

    /**
     * Delete a Appointment.
     */
    public function delete(Request $request)
    {
        try {
            // Get doctor ID from request
            $id = $request->Id;
            // Find the appointment
            $appointment = Appointment::find($id);
            if ($appointment) {
                // Delete the appointment
                $appointment->delete();

                // Delete related times
                Time::where('appointment_id', $id)->delete();

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Appointment not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

    }


    /**
     * Show the form for showing a doctor.
     */
    public function show($id)
    {
        // Retrieve Appointment data
        $appointmentdata = Appointment::where('id', $id)->first();

        $date = $appointmentdata->date;

        $times = Time::where('appointment_id',$id)->get();

        return view('doctor.appointment.show', compact('appointmentdata','date', 'times'));
    }


    public function check(Request $request)
    {
        $date = $request->date;
        $userid = $request->userid;
        $appointmentid = $request->appointmentid;
        $appointmentdata = Appointment::where('date', $date)->where('user_id', $userid)->first();

        if (!$appointmentdata) {
            return redirect()->route('doctor.appointment.show', ['id' => $appointmentid])
                            ->with('error', 'Appointment time not available for this date');
        }

        $appointmentId = $appointmentdata->id;
        $times = Time::where('appointment_id', $appointmentId)->get();

        return view('doctor.appointment.show', compact('times', 'appointmentdata', 'date'));
    }

    public function updateTime(Request $request){
        $appointmentId = $request->appoinmentId;
        $appointment = Time::where('appointment_id',$appointmentId)->delete();
        foreach($request->time as $time){
            Time::create([
                'appointment_id'=>$appointmentId,
                'time'=>$time,
                'status'=>0
            ]);
        }
        return redirect()->route('doctor.appointment.show', ['id' => $appointmentId])
                            ->with('success', 'Appointment time updated!!');
    }

}
