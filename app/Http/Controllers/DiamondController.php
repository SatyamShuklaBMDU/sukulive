<?php

namespace App\Http\Controllers;

use App\Models\Diamond;
use Exception;
use Illuminate\Http\Request;

class DiamondController extends Controller
{

    public function index()
    {
        $diamonds = Diamond::orderBy('id','desc')->get();
        return view('diamonds.index',compact('diamonds'));
    }

    public function store(Request $request) {
        $request->validate([
            'diamonds' => 'required|numeric',
            'mrp' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);

        $diamonds = new Diamond();
        $diamonds->diamonds = $request->diamonds;
        $diamonds->mrp = $request->mrp;
        $diamonds->selling_price = $request->selling_price;
        $diamonds->save();

        return response()->json(['success' => 'Diamond added successfully!']);
    
    }



    public function edit($id)
    {

        dd($id);

        $plans = Diamond::findOrFail($id);
        return response()->json($plans);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'diamonds' => 'required|numeric',
            'mrp' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);


        $diamonds = Diamond::findOrFail($id);
        $diamonds->diamonds = $request->diamonds;
        $diamonds->mrp = $request->mrp;
        $diamonds->selling_price = $request->selling_price;
        $diamonds->save();

        return response()->json(['success' => 'Diamond updated successfully.']);
    }



    public function destroy($id)
    {
        $notification = Diamond::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => 'Diamond deleted successfully.']);
    }


    public function updateStatus(Request $request, $id)
    {
        try {
            $user = Diamond::findOrFail($id);
            $user->is_active = $request->input('status');
            $user->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }


    



}
