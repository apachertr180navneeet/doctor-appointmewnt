<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationUser;
use Carbon\Carbon;
use Exception;
use Auth;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $notifications = Notification::whereIn('id', function ($query) use ($user) {
                $query->select('notification_id')
                      ->from(with(new NotificationUser)->getTable())
                      ->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            return view('admin.notifications.index', compact('notifications'));
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function clear()
    {
        try {
            $user = Auth::user();
            NotificationUser::where('user_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => Carbon::now()]);

            return back()->with('success', 'All notifications cleared successfully.');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            NotificationUser::where('user_id', $user->id)
                ->where('notification_id', $id)
                ->delete();

            return response()->json([
                'status' => true,
                'message' => 'Notification deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
