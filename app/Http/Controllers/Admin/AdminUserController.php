<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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

class AdminUserController extends Controller
{
    //========================= User Member Functions ========================//

    public function index() {
        return view('admin.users.index');
    }

    public function getAllUsers(Request $request) {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        return response()->json(['data' => $users]);
    }

    public function updateUserStatus(Request $request) {
        $validator = Validator::make($request->all(), [
            'userid' => 'required|exists:users,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }

        try {
            $user = User::findOrFail($request->userid);
            $user->status = $request->status;
            $user->save();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function profile() {
        $user = Auth::user();
        return view('web.auth.profile', compact('user'));
    }

    public function show($id) {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.show', compact('user'));
        } catch (Exception $e) {
            return redirect()->route('admin.users.index')->withError('User not found!');
        }
    }
}
