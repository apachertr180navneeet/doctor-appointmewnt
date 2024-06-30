<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Education, Department};
use Illuminate\Support\Facades\{Session, Redirect, Validator, Storage, Log};
use Mail, Hash, File, DB, Helper, Auth;
use Carbon\Carbon;

class DoctorController extends Controller
{
    //========================= User Member Functions ========================//

    /**
     * Display a listing of the doctors.
     */
    public function index()
    {
        // Retrieve all doctors
        $users = User::where('role', 'doctor')->get();
        return view('admin.doctor.index', compact('users'));
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create()
    {
        // Retrieve active educations and departments
        $educations = Education::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        return view('admin.doctor.create', compact('educations', 'departments'));
    }

    /**
     * Store a newly created doctor in the database.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
            'phone' => 'required|string|max:255',
            'gender' => 'required|string',
            'education' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'profile' => 'sometimes|image|mimes:jpeg,jpg,png|max:5000',
            'description' => 'required|string',
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Split the name into first and last name
        $nameParts = explode(' ', $request->name);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        // Generate a slug for the doctor
        $slug = method_exists('Helper', 'createSlug') ? Helper::createSlug($request->name) : str_slug($request->name);

        // Handle profile image upload
        $profile = $this->handleProfileImageUpload($request);

        // Prepare the data for insertion
        $doctorData = [
            'full_name' => $request->name,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'education' => $request->education,
            'department' => $request->department,
            'description' => $request->description,
            'slug' => $slug,
            'role' => 'doctor',
            'avatar' => $profile
        ];

        // Create the new doctor
        User::create($doctorData);

        // Redirect with success message
        return redirect()->route('admin.doctor.index')->with('success', 'Doctor added successfully');
    }

    /**
     * Update the status of a doctor.
     */
    public function status(Request $request)
    {
        try {
            // Get doctor ID and status from request
            $id = $request->id;
            $status = $request->status;

            // Update the status of the doctor
            User::where('id', $id)->update(['status' => $status]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete a doctor.
     */
    public function delete(Request $request)
    {
        try {
            // Get doctor ID from request
            $id = $request->id;

            // Find and delete the doctor
            $doctor = User::find($id);
            $doctor->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing a doctor.
     */
    public function edit($id)
    {
        // Retrieve doctor data, active educations, and departments
        $doctordata = User::find($id);
        $educations = Education::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();
        return view('admin.doctor.edit', compact('educations', 'departments', 'doctordata'));
    }

    /**
     * Update a doctor in the database.
     */
    public function update(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
                'phone' => 'required|string|max:255|unique:users,phone,' . $request->id,
                'gender' => 'required|string',
                'education' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'profile' => 'sometimes|image|mimes:jpeg,jpg,png|max:5000',
                'description' => 'required|string',
            ]);

            // Handle validation failures
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Split the name into first and last name
            $nameParts = explode(' ', $request->name);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            // Generate a slug for the doctor
            $slug = method_exists('Helper', 'createSlug') ? Helper::createSlug($request->name) : str_slug($request->name);

            // Handle profile image upload
            $profile = $this->handleProfileImageUpload($request);

            // Prepare the data for updating the doctor
            $doctorData = [
                'full_name' => $request->name,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'education' => $request->education,
                'department' => $request->department,
                'description' => $request->description,
                'slug' => $slug,
                'role' => 'doctor',
            ];

            // Add avatar if profile image is uploaded
            if ($profile !== "") {
                $doctorData['avatar'] = $profile;
            }

            // Update the doctor in the database
            User::where('id', $request->id)->update($doctorData);

            // Redirect with success message
            return redirect()->route('admin.doctor.index')->with('success', 'Doctor updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Handle profile image upload.
     */
    private function handleProfileImageUpload($request)
    {
        // Check if a profile image is uploaded
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $folder = 'uploads/user/';
            $path = public_path($folder);

            // Create directory if it doesn't exist
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true);
            }

            // Move the uploaded file
            $file->move($path, $filename);
            return $folder . $filename;
        }

        return '';
    }
}
