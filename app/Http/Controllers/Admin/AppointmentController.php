<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Appointment, Time};
use Illuminate\Support\Facades\{Session, Redirect, Validator, Storage, Log};
use Mail, Hash, File, DB, Helper, Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    //========================= Appointment Member Functions ========================//

    /**
     * Display a listing of the Appointment.
     */
    public function index($id)
    {
        $usersId = $id;
        // Retrieve all Appointment
        $appointments = Appointment::where('user_id', $usersId)->get();
        return view('admin.appointment.index',compact('usersId','appointments'));
    }

    /**
     * Show the form for creating a new Appointment.
     */
    public function create($id)
    {
        $usersId = $id;
        return view('admin.appointment.create',compact('usersId'));
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
            'user_id' => $request->userid,
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
        return redirect()->route('admin.appointment.index', ['id' => $request->userid])->with('success', 'Appointment created for '. $request->date);
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

        return view('admin.appointment.show', compact('appointmentdata','date', 'times'));
    }


    public function check(Request $request)
    {
        $date = $request->date;
        $userid = $request->userid;
        $appointmentid = $request->appointmentid;
        $appointment = Appointment::where('date', $date)->where('user_id', $userid)->first();

        if (!$appointment) {
            return redirect()->route('admin.appointment.show', ['id' => $appointmentid])
                            ->with('error', 'Appointment time not available for this date');
        }

        $appointmentId = $appointment->id;
        $times = Time::where('appointment_id', $appointmentId)->get();

        return view('admin.appointment.show', compact('times', 'appointmentId', 'date'));
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
        return redirect()->route('admin.appointment.show', ['id' => $appointmentId])
                            ->with('success', 'Appointment time updated!!');
    }

}
