<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employees;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::role('employee')
            ->get();

        return view('pages.employees.employee', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = null;
        $title = 'Create Employee';

        $department = Department::all();
        $position = Position::all();
        return view('pages.employees.employee-form', compact(['department', 'position', 'data', 'title']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'nik' => 'required',
            'join_date' => 'required',
            'department_id' => 'required',
            'position_id' => 'required',
            'salary_basic' => 'required',
            'bank_account' => 'required',
        ]);



        $password = Hash::make($request->password);

        $store_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);

        $store_employee = Employees::create([
            'user_id' => $store_user->id,
            'nik' => $request->nik,
            'join_date' => $request->join_date,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'salary_basic' => $request->salary_basic,
            'bank_account' => $request->bank_account,
        ]);

        $store_user->assignRole('employee');

        if ($store_user && $store_employee) {
            return redirect()->route('employee.employee.index')->with('success', 'The data has been created successfully');
        } else {
            return redirect()->route('employee.employee.index')->with('error', 'Failed to created the data. Please try again');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::findOrFail($id);
        $department = Department::all();
        $position = Position::all();
        return view('pages.employees.employee-show', compact(['department', 'position', 'data']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);
        $title = 'Create Employee';

        $department = Department::all();
        $position = Position::all();

        return view('pages.employees.employee-form', compact(['department', 'position', 'data', 'title']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'nik' => 'required',
            'join_date' => 'required',
            'department_id' => 'required',
            'position_id' => 'required',
            'salary_basic' => 'required',
            'bank_account' => 'required',
        ]);

        $data = User::findOrFail($id);
        $password = $data->password;

        if ($request->password != $data->password) {
            $password = Hash::make($request->password);
        }

        $update_user = User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);

        $update_employee = Employees::where('user_id', $id)->update([
            'nik' => $request->nik,
            'join_date' => $request->join_date,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'salary_basic' => $request->salary_basic,
            'bank_account' => $request->bank_account,
        ]);

        if ($update_user && $update_employee) {
            return redirect()->route('employee.employee.index')->with('success', 'The data has been updated successfully');
        } else {
            return redirect()->route('employee.employee.index')->with('error', 'Failed to updated the data. Please try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete_employee = Employees::where('user_id', $id)->delete();
        $delete = User::findOrFail($id)->delete();
        if ($delete_employee && $delete) {
            return redirect()->route('employee.employee.index')->with('success', 'The data has been deleted successfully');
        } else {
            return redirect()->route('employee.employee.index')->with('error', 'Failed to deleted the data. Please try again');
        }
    }
}
