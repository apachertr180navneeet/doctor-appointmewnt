<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
        User,
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
use App\Models\Notification;
use App\Models\NotificationUser;
use Exception;

class DepartmentController extends Controller
{
    // Department Function
    public function index() {
        return view('admin.department.index');
    }

    public function getallDepartment(Request $request) {
        $department = Department::get();
        return response()->json(['data' => $department]);
    }

    /**
     * Store a newly created unit.
     */
    public function store(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:department,department',
            ]);

            if ($validator->fails()) {
                // Check if unit with the same name and code exists (including soft deleted ones)
                $departmentCheck = Department::withTrashed()->where('department', $request->name)->first();

                if (!empty($departmentCheck)) {
                    // If found, restore the soft deleted record
                    $record = Department::withTrashed()->find($departmentCheck->id);
                    $record->restore();
                    return response()->json(['success' => 'Department added successfully']);
                } else {
                    // If validation fails and no duplicate found, return validation errors
                    return response()->json(['errors' => $validator->errors()->all()]);
                }
            }

            // If validation passes, create a new unit
            Department::create([
                'department' => $request->name,
            ]);

            return response()->json(['success' => 'Department added successfully']);
        } catch (\Throwable $th) {
            dd($th); // Again, consider logging instead of dumping
        }
    }


    /**
     * Update the status of a Department.
     */
    public function status(Request $request)
    {
        try {
            // Get unit ID and status from request
            $departmentId = $request->departmentId;
            $status = $request->status;

            // Update status of the Department
            Department::where('id', $departmentId)->update(['status' => $status]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete a Department.
     */
    public function delete(Request $request)
    {
        try {
            // Get unit ID from request
            $departmentId = $request->departmentId;

            // Find and delete the Department
            $department = Department::find($departmentId);
            $department->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    /**
     * Retrieve a Department for editing.
     */
    public function edit(Request $request)
    {
        try {
            // Get unit ID from request
            $departmentId = $request->departmentId;

            // Find the unit
            $department = Department::find($departmentId);
            return response()->json(['success' => true, 'data' => $department]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update a Department.
     */
    public function update(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'departmentName' => 'required|string|max:255|unique:department,department',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            // Update Department data
            $Departmentdata =[
                'department' => $request->departmentName,
            ];

            // Update the unit
            Department::where('id', $request->departmentId)->update($Departmentdata);

            return response()->json(['success' => 'Department Edit successfully']);
        } catch (\Throwable $th) {
            dd($th); // Again, consider logging instead of dumping
        }
    }
}
