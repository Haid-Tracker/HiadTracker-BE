<?php

namespace App\Http\Controllers;

use App\Models\CycleRecord;
use Illuminate\Http\Request;

class CycleRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = CycleRecord::all();
        return view('backend.cycle-record.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $userId)
    {
        $datas = CycleRecord::find($userId);
        return view('backend.cycle-record.edit', compact('datas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $userId)
    {
        $request->validate([
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'predicteddate' => 'nullable|date',
            'bloodvolume' => 'required|in:light,medium,heavy',
            'mood' => 'nullable|string|max:255',
        ]);

        $data = CycleRecord::find($userId);


        if (!$data) {
            return redirect()->route('user.cycle-record')->with('error', 'Record not found.');
        }


        $data->start_date = $request->input('startdate');
        $data->end_date = $request->input('enddate');
        $data->predicted_date = $request->input('predicteddate');
        $data->blood_volume = $request->input('bloodvolume');
        $data->mood = $request->input('mood');


        $data->save();


        return redirect()->route('user.cycle-record')->with('success', 'Record updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datas = CycleRecord::find($id);

    if (!$datas) {
        return redirect()->route('user.cycle-record')->with('error', 'Record not found.');
    }


    $datas->delete();


    return redirect()->route('user.cycle-record')->with('success', 'Record deleted successfully.');
    }
}
