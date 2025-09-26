<?php

namespace App\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentLivewire extends Component
{
    public $data, $show_modal = false, $mode = '';
    public $name, $id;

    public function mount()
    {
        $this->getDepartment();
    }

    public function getDepartment()
    {
        $this->data = Department::all();
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
                $data = Department::findOrFail($id);
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
        $this->getDepartment();
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

        $store = Department::create([
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
        $update = Department::findOrFail($this->id)->update([
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
        $delete = Department::findOrFail($id)->delete();
        if ($delete) {
            session()->flash('success', 'The data has been deleted successfully');
        } else {
            session()->flash('error', 'Failed to deleted the data. Please try again');
        }

        $this->getDepartment();
        $this->dispatch('reinitComponents');
    }

    public function render()
    {
        return view('pages.employees.department')->layout('layouts.app');
    }
}
