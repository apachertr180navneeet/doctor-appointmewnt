<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Role
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

class RoleController extends Controller
{
    // role Function
    public function index() {
        return view('admin.role.index');
    }

    public function getallList(Request $request) {
        $role = Role::get();
        return response()->json(['data' => $role]);
    }

    /**
     * Store a newly created unit.
     */
    public function store(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:roles,name',
            ]);

            if ($validator->fails()) {
                // Check if unit with the same name and code exists (including soft deleted ones)
                $roleCheck = Role::withTrashed()->where('name', $request->name)->first();

                if (!empty($roleCheck)) {
                    // If found, restore the soft deleted record
                    $record = Role::withTrashed()->find($roleCheck->id);
                    $record->restore();
                    return response()->json(['success' => 'role added successfully']);
                } else {
                    // If validation fails and no duplicate found, return validation errors
                    return response()->json(['errors' => $validator->errors()->all()]);
                }
            }

            // If validation passes, create a new unit
            Role::create([
                'name' => $request->name,
            ]);

            return response()->json(['success' => 'role added successfully']);
        } catch (\Throwable $th) {
            dd($th); // Again, consider logging instead of dumping
        }
    }


    /**
     * Update the status of a role.
     */
    public function status(Request $request)
    {
        try {
            // Get unit ID and status from request
            $id = $request->id;
            $status = $request->status;

            // Update status of the role
            Role::where('id', $id)->update(['status' => $status]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete a role.
     */
    public function delete(Request $request)
    {
        try {
            // Get unit ID from request
            $Id = $request->Id;

            // Find and delete the role
            $role = Role::find($Id);
            $role->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    /**
     * Retrieve a role for editing.
     */
    public function edit(Request $request)
    {
        try {
            // Get unit ID from request
            $Id = $request->Id;

            // Find the unit
            $role = Role::find($Id);
            return response()->json(['success' => true, 'data' => $role]);
        } catch (\Exception $e) { // Changed to \Exception for consistency
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update a role.
     */
    public function update(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'roleName' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            // Update role data
            $roledata =[
                'name' => $request->roleName,
            ];

            // Update the unit
            Role::where('id', $request->roleId)->update($roledata);

            return response()->json(['success' => 'role Edit successfully']);
        } catch (\Throwable $th) {
            dd($th); // Again, consider logging instead of dumping
        }
    }
}
