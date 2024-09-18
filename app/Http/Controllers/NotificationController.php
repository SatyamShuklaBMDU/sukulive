<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        return view('notifications.index', compact('notifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'for' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::create($request->all());

        return response()->json(['success' => 'Notification added successfully.']);
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'for' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->update($request->all());

        return response()->json(['success' => 'Notification updated successfully.']);
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => 'Notification deleted successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $user = Notification::findOrFail($id);
            $user->status = $request->input('status');
            $user->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }
}
