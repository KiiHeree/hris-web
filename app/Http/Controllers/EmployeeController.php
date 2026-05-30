<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EmployeeDocument;
use App\Models\Employees;
use App\Models\EmployeeSalaryComponent;
use App\Models\EmploymentStatus;
use App\Models\Position;
use App\Models\SalaryComponent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = User::role('employee')->get();
        $data = User::all();

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
        $manager = Employees::all();
        $status = EmploymentStatus::all();
        $salary_component = SalaryComponent::all();
        $detail_salary = [];
        $detail_document = [];
        return view('pages.employees.employee-form', compact(['department', 'position', 'data', 'title', 'salary_component', 'status', 'manager','detail_salary','detail_document']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
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


        try {
            DB::beginTransaction();
            $password = Hash::make($request->password);

            $store_user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
            ]);

            $store_employee = Employees::create([
                'user_id' => $store_user->id,
                'full_name' => $request->full_name,
                'nik' => $request->nik,
                'join_date' => $request->join_date,
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'salary_basic' => $request->salary_basic,
                'bank_account' => $request->bank_account,
                'bank_name' => $request->bank_name,
                'gender' => $request->gender,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'telp' => $request->telp,
                'address' => $request->address,
                'manager_id' => $request->manager_id,
                'employment_status_id' => $request->employment_status_id,
                'notes' => $request->notes,
                'npwp' => $request->npwp,
                'email' => $request->email,
            ]);

            foreach ($request->input('salary_components', []) as $component) {
                $salary_component = EmployeeSalaryComponent::create([
                    'employee_id' => $store_employee->id,
                    'salary_component_id'   => $component['type'],
                    'value' => $component['amount'],
                ]);
            }

            // Documents
            foreach ($request->input('documents', []) as $i => $doc) {
                $file = $request->file("documents.{$i}.file");
                $path = $file->store('employee-documents', 'public');

                $employee_document = EmployeeDocument::create([
                    'employee_id' => $store_employee->id,
                    'type' => $doc['type'],
                    'file_path' => $path,
                ]);
            }

            $store_user->assignRole('employee');
            DB::commit();
            if ($store_employee && $store_user) {
                return redirect()->route('employee.employee.index')->with('success', 'The data has been created successfully');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to create employee: ' . $e->getMessage());
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
        $data = Employees::where('user_id', $id)->first();
        $detail_salary = EmployeeSalaryComponent::where('employee_id', $id)->get();
        $detail_document = EmployeeDocument::where('employee_id', $id)->get();
        $title = 'Update Employee';

        $department = Department::all();
        $position = Position::all();
        $manager = Employees::all();
        $status = EmploymentStatus::all();
        $salary_component = SalaryComponent::all();
        return view('pages.employees.employee-form', compact(['department', 'position', 'data', 'detail_salary', 'detail_document', 'title', 'salary_component', 'status', 'manager']));
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

        try {
            DB::beginTransaction();
            $data = User::findOrFail($id);
            $password = $data->password;

            if ($request->password != '' || $request->password != null) {
                $password = Hash::make($request->password);
            }

            $update_user = User::findOrFail($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
            ]);

            $update_employee = Employees::where('user_id', $id)->first();
            $update_employee->update([
                'full_name' => $request->full_name,
                'nik' => $request->nik,
                'join_date' => $request->join_date,
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'salary_basic' => $request->salary_basic,
                'bank_account' => $request->bank_account,
                'bank_name' => $request->bank_name,
                'gender' => $request->gender,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'telp' => $request->telp,
                'address' => $request->address,
                'manager_id' => $request->manager_id,
                'employment_status_id' => $request->employment_status_id,
                'notes' => $request->notes,
                'npwp' => $request->npwp,
                'email' => $request->email,
            ]);

            $employee_id = $update_employee->id;

            // Salary
            $salary_id  = EmployeeSalaryComponent::where('employee_id', $employee_id)->pluck('id')->toArray();
            $salary_submit_id = [];
            foreach ($request->input('salary_components', []) as $component) {
                if (!empty($component['id'])) {
                    // data lama → update
                    EmployeeSalaryComponent::where('id', $component['id'])->update([
                        'salary_component_id' => $component['type'],
                        'value'              => $component['amount'],
                    ]);
                    $salary_submit_id[] = (int) $component['id'];
                } else {
                    // data baru → insert
                    EmployeeSalaryComponent::create([
                        'employee_id'         => $employee_id,
                        'salary_component_id' => $component['type'],
                        'value'              => $component['amount'],
                    ]);
                }
            }

            // yang dihapus user → delete dari DB
            $toDelete = array_diff($salary_id, $salary_submit_id);
            if (!empty($toDelete)) {
                EmployeeSalaryComponent::whereIn('id', $toDelete)->delete();
            }

            // Documents
            $document_id  = EmployeeDocument::where('employee_id', $employee_id)->pluck('id')->toArray();
            $document_submit_id = [];

            foreach ($request->input('documents', []) as $i => $doc) {
                $file = $request->file("documents.$i.file");

                if (!empty($doc['id'])) {
                    // data lama
                    $updateData = ['type' => $doc['type']];

                    if ($file) {
                        // ada file baru → hapus lama, simpan baru
                        Storage::disk('public')->delete($doc['existing_file']);
                        $updateData['file_path'] = $file->store('employee-documents', 'public');
                    }
                    // ga ada file baru → file lama tetap, ga diapa-apain

                    EmployeeDocument::where('id', $doc['id'])->update($updateData);
                    $document_submit_id[] = (int) $doc['id'];
                } else {
                    if (!$file) continue;
                    // data baru → wajib ada file
                    $path = $file->store('employee-documents', 'public');
                    EmployeeDocument::create([
                        'employee_id' => $employee_id,
                        'type'        => $doc['type'],
                        'file_path'   => $path,
                    ]);
                }
            }

            // hapus yang dihilangkan user
            $toDelete = array_diff($document_id, $document_submit_id);
            if (!empty($toDelete)) {
                foreach (EmployeeDocument::whereIn('id', $toDelete)->get() as $doc) {
                    Storage::disk('public')->delete($doc->file_path);
                }
                EmployeeDocument::whereIn('id', $toDelete)->delete();
            }

            DB::commit();
            if ($update_user && $update_employee) {
                return redirect()->route('employee.employee.index')->with('success', 'The data has been updated successfully');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to update employee: ' . $e->getMessage());
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
