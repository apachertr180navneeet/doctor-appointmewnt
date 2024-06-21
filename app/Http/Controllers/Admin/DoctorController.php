<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Education,
    Department
};

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;

class DoctorController extends Controller
{
    //========================= User Member Functions ========================//

    public function index() {
        return view('admin.doctor.index');
    }

    public function create() {
        $eductions = Education::where('status','active')->get();
        $departments = Department::where('status','active')->get();
        return view('admin.doctor.create',compact('eductions','departments'));
    }

     /**
     * Store a newly created unit.
     */
    public function store(Request $request)
    {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|max:255|confirmed',
                'phone' => 'required|string|max:255',
                'gender' => 'required|string',
                'education' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'profile' => 'required|file',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Prepare the data for insertion
            $doctorData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'gender' => $request->gender,
                'education' => $request->education,
                'department' => $request->department,
                'profile' => $request->file('profile')->store('profiles', 'public'),
                'description' => $request->description,
                'description' => $request->description,
            ];

            // Create the new user
            User::create($doctorData);

            return response()->json(['success' => 'User added successfully']);
    }
}
