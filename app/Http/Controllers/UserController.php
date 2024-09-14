<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = Customer::latest()->get();
        return view('users.index', compact('users'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $user = Customer::findOrFail($id);
            $user->status = $request->input('status');
            $user->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }

    public function filterData(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $startDate = $request->start;
        $endDate = $request->end;
        $users = Customer::whereBetween('created_at', [$startDate, $endDate])->latest()->get();
        return view("users.index", ['start' => $startDate, 'end' => $endDate], compact("users"));
    }
}
