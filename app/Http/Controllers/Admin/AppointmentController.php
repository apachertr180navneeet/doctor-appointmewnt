<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    //========================= Appointment Member Functions ========================//

    /**
     * Display a listing of the Appointment.
     */
    public function index()
    {
        // Retrieve all Appointment
        return view('admin.appointment.index');
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create()
    {
        return view('admin.appointment.create');
    }
}
