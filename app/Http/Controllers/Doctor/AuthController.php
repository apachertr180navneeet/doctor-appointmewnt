<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Education, Department};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use DB;
use Hash;
use Validator;
use Session;
use File;
use Exception;
use App\Rules\PhoneNumber;

class AuthController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();

            if ($user) {
                if ($user->role == "doctor") {
                    return redirect()->route('doctor.dashboard');
                }

                return back()->with("error", "Oops! You do not have access to this");
            }

            return redirect()->route('doctor.login');
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function login()
    {
        return view("doctor.auth.login");
    }

    public function postLogin(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required",
            ]);

            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'doctor'
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->route("doctor.dashboard")->with("success", "Welcome to your dashboard.");
            }

            return back()->with("error", "Invalid credentials");
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function register()
    {
        return view("doctor.auth.register");
    }

    public function postRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|unique:users",
            "phone" => "required|unique:users",
            "password" => "required|min:6|confirmed",
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $this->create($data);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'doctor'
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route("doctor.dashboard")->with("success", "Great! You have successfully registered.");
        }
    }

    private function create(array $data)
    {
        $dataname = explode(" ", $data['name']);
        $slug = $this->createSlug($data['name']);
        if (count($dataname) < 2) {

            return User::create([
                "first_name" => $dataname['0'] ?? '',
                "last_name" => $dataname['1'] ?? '',
                "full_name" => $data["name"] ?? '',
                "slug" => $slug,
                "email" => $data["email"],
                "password" => Hash::make($data["password"]),
                "role" => "doctor",
                "phone" => $data["phone"],
                "address" => $data["address"],
                "gender" => $data["gender"],

            ]);
        }else{
            return User::create([
                "first_name" => $dataname['0'] ?? '',
                "last_name" => $dataname['1'] ?? '',
                "full_name" => $data["name"] ?? '',
                "slug" => $slug,
                "email" => $data["email"],
                "password" => Hash::make($data["password"]),
                "role" => "doctor",
                "phone" => $data["phone"],
                "address" => $data["address"],
                "gender" => $data["gender"],

            ]);
        }
    }

    private function createSlug($string) {
        // Convert the string to lowercase
        $slug = strtolower($string);

        // Remove any character that is not alphanumeric, a space, or a hyphen
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

        // Replace multiple spaces or hyphens with a single space
        $slug = preg_replace('/[\s-]+/', ' ', $slug);

        // Replace spaces with hyphens
        $slug = preg_replace('/\s/', '-', $slug);

        // Trim hyphens from the beginning and end
        $slug = trim($slug, '-');

        return $slug;
    }

    public function doctorDashoard()
    {
        return view("doctor.dashboard.index");
    }

    public function logout()
    {
        try {
            Session::flush();
            Auth::logout();
            return redirect()->route("doctor.login")->with("success", "Logout Successful!");
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function showForgetPasswordForm()
    {
        return view("doctor.auth.forgot-password");
    }

    public function submitForgetPasswordForm(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email|exists:users",
            ]);

            $token = Str::random(64);

            DB::table("password_resets")->insert([
                "email" => $request->email,
                "token" => $token,
                "created_at" => Carbon::now(),
            ]);

            $resetLink = url("doctor/reset-password/" . $token);
            Mail::send("email.forgot-password", ["token" => $resetLink, "email" => $request->email], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject("Reset Password");
            });

            return redirect()->route("doctor.login")->with("success", "We have e-mailed your password reset link!");
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function showResetPasswordForm($token)
    {
        try {
            $user = DB::table("password_resets")->where("token", $token)->first();
            return view("doctor.auth.reset-password", ["token" => $token, "email" => $user->email]);
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function submitResetPasswordForm(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email|exists:users",
                "password" => "required|string|min:6|confirmed",
                "password_confirmation" => "required",
            ]);

            $updatePassword = DB::table("password_resets")->where(["email" => $request->email, "token" => $request->token])->first();

            if (!$updatePassword) {
                return back()->withInput()->with("error", "Invalid token!");
            }

            User::where("email", $request->email)->update(["password" => Hash::make($request->password)]);

            DB::table("password_resets")->where(["email" => $request->email])->delete();

            return redirect()->route("doctor.login")->with("success", "Your password has been changed successfully!");
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function changePassword()
    {
        return view("doctor.auth.change-password");
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                "old_password" => "required",
                "new_password" => "required|confirmed",
            ]);

            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return back()->with("error", "Old Password doesn't match!");
            }

            auth()->user()->update([
                "password" => Hash::make($request->new_password),
            ]);

            return back()->with("success", "Password changed successfully!");
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function adminProfile()
    {
        try {
            $user = Auth::user();

            $educations = Education::where('status', 'active')->get();
            $departments = Department::where('status', 'active')->get();

            return view("doctor.auth.profile", compact("user","educations","departments"));
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function updateAdminProfile(Request $request)
    {
        try {
            $user = Auth::user();
            $data = $request->all();

            $validator = Validator::make($data, [
                "first_name" => "required",
                "last_name" => "required",
                "phone" => "required|min:9|unique:users,phone," . $user->id,
                "email" => "required|email|unique:users,email," . $user->id,
                "avatar" => "sometimes|image|mimes:jpeg,jpg,png|max:5000"
            ]);

            if ($validator->fails()) {
                return back()->withInput($request->all())->withErrors($validator->errors());
            }

            if ($request->hasFile("avatar")) {
                $file = $request->file("avatar");
                $filename = time() . '_' . $file->getClientOriginalName();
                $folder = "uploads/user/";
                $path = public_path($folder);

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                $file->move($path, $filename);
                $user->avatar = $folder . $filename;
            }

            $user->update([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "full_name" => $request->first_name . ' ' . $request->last_name,
                "phone" => $request->phone,
                "email" => $request->email,
                'gender' => $request->gender,
                'education' => $request->education,
                'department' => $request->department,
            ]);

            return back()->with("success", "Profile updated successfully!");
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }
}
