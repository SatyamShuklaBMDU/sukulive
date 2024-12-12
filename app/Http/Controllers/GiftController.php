<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\Gift;
use Exception;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index()
    {
        $gifts = Gift::orderBy('id', 'desc')->get();
        return view('gift.index', compact('gifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'gift' => 'required|file|mimes:svg',
        ]);
        $fileUrl = '';
        if ($request->hasFile('gift')) {
            $file = $request->file('gift');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $fileUrl = FileHelper::storeFile($file, 'Gift/' , $fileName);
        }
        Gift::create([
            'name' => $request->input('title'),
            'price' => $request->input('price'),
            'image'=> $fileUrl,
        ]);
        return redirect()->route('gifts.index')->with('success', 'Gift created successfully.');
    }

    public function edit($id)
    {
        $plans = Gift::findOrFail($id);
        return response()->json($plans);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'gift' => 'required|file|mimes:svg',
        ]);
        $notification = Gift::findOrFail($id);
        if ($request->hasFile('gift')) {
            $file = $request->file('gift');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $$notification->image = FileHelper::storeFile($file, 'Gift/' , $fileName);
            $notification->save();
        }
        $notification->update(
            [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
            ]
        );
        return response()->json(['success' => 'Gift updated successfully.']);
    }


    public function destroy($id)
    {
        $notification = Gift::findOrFail($id);
        $notification->delete();
        return response()->json(['success' => 'Gift deleted successfully.']);
    }


    public function updateStatus(Request $request, $id)
    {
        try {
            $user = Gift::findOrFail($id);
            $user->is_active = $request->input('status');
            $user->save();
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }
}
