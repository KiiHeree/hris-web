<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cuti::where('employee_id', Auth::id())->get();

        return view('pages.leave.leave-history', compact('data'));
    }


    public function leave_reports()
    {
        $data = Cuti::all();

        return view('pages.reports.leave-reports', compact('data'));
    }

    public function approval_page()
    {
        $data = Cuti::where('status', '=', 'pending')->get();
        return view('pages.leave.leave-approval', compact('data'));
    }

    public function approve(Request $request, $id)
    {
        $status_update = Cuti::where('status', '=', 'pending')->where('id', $id)->update([
            'status' => $request->status,
            'approver_id' => Auth::id()
        ]);

        if ($status_update) {
            return redirect()->route('leave.approval_page')->with('success', 'The data has been updated successfully');
        } else {
            return redirect()->route('leave.approval_page')->with('error', 'Failed to updated the data. Please try again');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = null;
        $type = ['izin', 'sakit', 'cuti'];
        $title = 'Create Leave';
        return view('pages.leave.leave-form', compact(['data', 'title', 'type']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'deskripsi',
            'start_date',
            'end_date',
            'type'
        ]);

        $store_leave = Cuti::create([
            'employee_id' => Auth::id(),
            'deskripsi' => $request->deskripsi,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'status' => 'pending',
        ]);

        if ($store_leave) {
            return redirect()->route('leave.leave.index')->with('success', 'The data has been created successfully');
        } else {
            return redirect()->route('leave.leave.index')->with('error', 'Failed to created the data. Please try again');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Cuti::where('employee_id', $id)->first();
        $type = ['izin', 'sakit', 'cuti'];


        return view('pages.leave.leave-show', compact(['data', 'type']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Cuti::where('employee_id', $id)->first();
        $title = 'Create Leave';
        $type = ['izin', 'sakit', 'cuti'];

        return view('pages.leave.leave-form', compact(['data', 'title', 'type']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'deskripsi',
            'start_date',
            'end_date',
            'type'
        ]);

        $update_leave = Cuti::findOrFail($id)->update([
            'deskripsi' => $request->deskripsi,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type
        ]);

        if ($update_leave) {
            return redirect()->route('leave.leave.index')->with('success', 'The data has been updated successfully');
        } else {
            return redirect()->route('leave.leave.index')->with('error', 'Failed to updated the data. Please try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete_leave = Cuti::findOrFail($id)->delete();
        if ($delete_leave) {
            return redirect()->route('leave.leave.index')->with('success', 'The data has been deleted successfully');
        } else {
            return redirect()->route('leave.leave.index')->with('error', 'Failed to deleted the data. Please try again');
        }
    }
}
