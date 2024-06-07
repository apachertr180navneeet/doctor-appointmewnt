<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Exception;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index');
    }

    public function getAllContact(Request $request)
    {
        $contacts = Contact::orderBy('id', 'desc')->get();
        return response()->json(['data' => $contacts]);
    }

    public function contactUsSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->message = $request->message;
            $contact->save();

            $adminEmail = config('mail.admin_email'); // Assuming admin email is set in config
            Mail::to($adminEmail)->send(new ContactMail($contact));

            DB::commit();
            return redirect()->route('/')->with('success', 'Thank you for getting in touch!');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Contact Us Submit Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An error occurred. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();

            return response()->json([
                'success' => 'success',
                'message' => 'Deleted successfully',
            ]);
        } catch (Exception $e) {
            Log::error('Contact Delete Error: ' . $e->getMessage());
            return response()->json([
                'success' => 'error',
                'message' => 'An error occurred. Please try again later.',
            ]);
        }
    }
}
