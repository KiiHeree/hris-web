<?php

namespace App\Livewire;

use App\Models\Employees;
use App\Models\User;
use Livewire\Component;

class EmployeeLivewire extends Component
{
    public $data, $show_modal = false, $mode = '';
    public $name, $id;

    public function mount()
    {
        $this->getEmployees();
    }

    public function getEmployees()
    {
        $this->data = User::role('employee')
            ->with('employee')
            ->get();
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
    }

    public function store()
    {
        $this->validate([
            'name' => 'required'
        ]);

        $store = User::create([
            'name' => $this->name
        ]);

        if ($store) {
            session()->flash('success', 'The data has been created successfully');
        } else {
            session()->flash('error', 'Failed to create the data. Please try again');
        }

        $this->closeModal();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required'
        ]);
        $update = User::findOrFail($this->id)->update([
            'name' => $this->name
        ]);

        if ($update) {
            session()->flash('success', 'The data has been updated successfully');
        } else {
            session()->flash('error', 'Failed to updated the data. Please try again');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
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
