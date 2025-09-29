<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Employees;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EmployeeLivewire extends Component
{
    public $data, $department, $position, $show_modal = false, $mode = '';
    public $name, $email, $password, $id, $nik, $join_date, $department_id, $position_id, $salary_basic, $bank_account;

    public function mount()
    {
        $this->getEmployees();
    }

    public function getEmployees()
    {
        $this->data = User::role('employee')
            ->get();
        $this->department = Department::all();
        $this->position = Position::all();
    }

    public function showModal($mode, $id = 0)
    {
        $this->mode = $mode;
        $this->show_modal = true;
        switch ($this->mode) {
            case 'create':
                $this->resetForm();
                break;
            case 'update';
                $this->id = $id;
                $data = User::findOrFail($id);
                if (!$data) {
                    session()->flash('error', "Data not found");
                }
                $this->name = $data->name;
                $this->email = $data->email;
                $this->password = $data->password;
                $this->nik = $data->employee->nik;
                $this->join_date = $data->employee->join_date;
                $this->department_id = $data->employee->department_id;
                $this->position_id = $data->employee->position_id;
                $this->salary_basic = $data->employee->salary_basic;
                $this->bank_account = $data->employee->bank_account;
                break;
            default:
                session()->flash('error', 'Modal error');
                break;
        }
    }

    public function closeModal()
    {
        $this->show_modal = false;
        $this->resetForm();
        $this->dispatch('reinitComponents');
        $this->getEmployees();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->nik = '';
        $this->join_date = '';
        $this->department_id = '';
        $this->position_id = '';
        $this->salary_basic = '';
        $this->bank_account = '';
    }

    public function store()
    {
        dd('p');
        $this->validate([
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



        $password = Hash::make($this->password);

        $store_user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $password,
        ]);

        $store_employee = Employees::create([
            'nik' => $this->nik,
            'join_date' => $this->join_date,
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
            'salary_basic' => $this->salary_basic,
            'bank_account' => $this->bank_account,
        ]);

        if ($store_user && $store_employee) {
            session()->flash('success', 'The data has been created successfully');
        } else {
            session()->flash('error', 'Failed to create the data. Please try again');
        }

        $this->closeModal();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'nik' => 'required',
            'join_date' => 'required',
            'department_id' => 'required',
            'position_id' => 'required',
            'salary_basic' => 'required',
            'bank_account' => 'required',
        ]);

        $data = User::findOrFail($this->id);
        $password = $data->password;

        if ($this->password != $data->password) {
            $password = Hash::make($this->password);
        }

        $update_user = User::findOrFail($this->id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $password,
        ]);

        $update_employee = Employees::findOrFail($this->id)->update([
            'nik' => $this->nik,
            'join_date' => $this->join_date,
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
            'salary_basic' => $this->salary_basic,
            'bank_account' => $this->bank_account,
        ]);

        if ($update_user && $update_employee) {
            session()->flash('success', 'The data has been updated successfully');
        } else {
            session()->flash('error', 'Failed to updated the data. Please try again');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $delete_employee = Employees::findOrFail($id)->delete();
        $delete = User::findOrFail($id)->delete();
        if ($delete) {
            session()->flash('success', 'The data has been deleted successfully');
        } else {
            session()->flash('error', 'Failed to deleted the data. Please try again');
        }

        $this->getEmployees();
        $this->dispatch('reinitComponents');
    }

    public function render()
    {
        return view('pages.employees.employee')->layout('layouts.app');
    }
}
