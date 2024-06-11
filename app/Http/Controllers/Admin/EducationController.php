<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
        User,
        Education
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

class EducationController extends Controller
{
    // education Function
    public function index() {
        return view('admin.education.index');
    }

    public function getallList(Request $request) {
        $education = Education::get();
        return response()->json(['data' => $education]);
    }

    /**
     * Store a newly created unit.
     */
    public function store(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:education,name',
            ]);

            if ($validator->fails()) {
                // Check if unit with the same name and code exists (including soft deleted ones)
                $educationCheck = Education::withTrashed()->where('name', $request->name)->first();

                if (!empty($educationCheck)) {
                    // If found, restore the soft deleted record
                    $record = Education::withTrashed()->find($educationCheck->id);
                    $record->restore();
                    return response()->json(['success' => 'education added successfully']);
                } else {
                    // If validation fails and no duplicate found, return validation errors
                    return response()->json(['errors' => $validator->errors()->all()]);
                }
            }

            // If validation passes, create a new unit
            Education::create([
                'name' => $request->name,
            ]);

            return response()->json(['success' => 'education added successfully']);
        } catch (\Throwable $th) {
            dd($th); // Again, consider logging instead of dumping
        }
    }


    /**
     * Update the status of a education.
     */
    public function status(Request $request)
    {
        try {
            // Get unit ID and status from request
            $id = $request->id;
            $status = $request->status;

            // Update status of the education
            Education::where('id', $id)->update(['status' => $status]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete a education.
     */
    public function delete(Request $request)
    {
        try {
            // Get unit ID from request
            $Id = $request->Id;

            // Find and delete the education
            $education = Education::find($Id);
            $education->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    /**
     * Retrieve a education for editing.
     */
    public function edit(Request $request)
    {
        try {
            // Get unit ID from request
            $Id = $request->Id;

            // Find the unit
            $education = Education::find($Id);
            return response()->json(['success' => true, 'data' => $education]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update a education.
     */
    public function update(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'educationName' => 'required|string|max:255|unique:education,name',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            // Update education data
            $educationdata =[
                'name' => $request->educationName,
            ];

            // Update the unit
            Education::where('id', $request->educationId)->update($educationdata);

            return response()->json(['success' => 'education Edit successfully']);
        } catch (\Throwable $th) {
            dd($th); // Again, consider logging instead of dumping
        }
    }
}
