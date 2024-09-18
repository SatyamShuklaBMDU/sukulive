<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index()
    {

        $plans=Plan::orderBy('id','desc')->get();
        // dd($plans);
        return view('plans.index',compact('plans'));
    }



    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|in:weekly,monthly,yearly',
            'trial_period_days' => 'nullable|numeric|min:0',
            'plan_type' => 'required|in:free,paid',
            'feature' => 'required|array',
            'feature.*' => 'string|max:255',
        ]);

        // Create a new plan
        Plan::create([
            'name' => $request->input('title'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
            'trial_period_days' => $request->input('trial_period_days') ? $request->input('trial_period_days') : 0,
            'plan_type' => $request->input('plan_type'),
            'features' => json_encode($request->input('feature')), // Store features as JSON
        ]);

        // Redirect to the plans list page with a success message
        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }



    public function edit($id)
    {
        $plans = Plan::findOrFail($id);
        $plans->features = json_decode($plans->features, true);
        return response()->json($plans);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|in:weekly,monthly,yearly',
            'trial_period_days' => 'nullable|numeric|min:0',
            'plan_type' => 'required|in:free,paid',
            'feature' => 'required|array',
            'feature.*' => 'string|max:255',
        ]);

        $notification = Plan::findOrFail($id);

        // dd($notification);


        $notification->update(
            [
                'name' => $request->input('name'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
            'trial_period_days' => $request->input('trial_period_days') ? $request->input('trial_period_days') : 0,
            'plan_type' => $request->input('plan_type'),
            'features' => json_encode($request->input('feature')), // Store features as JSON
            ]
        );

        return response()->json(['success' => 'Plan updated successfully.']);
    }


    public function destroy($id)
    {
        $notification = Plan::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => 'Plan deleted successfully.']);
    }


    public function updateStatus(Request $request, $id)
    {
        try {
            $user = Plan::findOrFail($id);
            $user->is_active = $request->input('status');
            $user->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }

}
