<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Holiday::all();

        return view('pages.holiday.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create';
        $data = '';

        return view('pages.holiday.holiday-form',compact(['title','data']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'description' => 'required'
        ]);

        $store = Holiday::created([
            'date' => $request->date,
            'description' => $request->description
        ]);

        if ($store) {
            return redirect()->route('setting.holiday.index')->with('success', 'The data has been created successfully');
        } else {
            return redirect()->route('setting.holiday.index')->with('error', 'Failed to created the data. Please try again');
        }
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
    public function edit(string $id)
    {
        $title = 'Update';
        $data = Holiday::where('id',$id)->first();

        return view('pages.holiday.holiday-form',compact(['title','data']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required',
            'description' => 'required'
        ]);

        $update = Holiday::where('id',$id)->update([
            'date' => $request->date,
            'description' => $request->description
        ]);

        if ($update) {
            return redirect()->route('setting.holiday.index')->with('success', 'The data has been update successfully');
        } else {
            return redirect()->route('setting.holiday.index')->with('error', 'Failed to update the data. Please try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Holiday::where('id',$id)->delete();

        if ($delete) {
            return redirect()->route('setting.holiday.index')->with('success', 'The data has been deleted successfully');
        } else {
            return redirect()->route('setting.holiday.index')->with('error', 'Failed to deleted the data. Please try again');
        }
    }
}
