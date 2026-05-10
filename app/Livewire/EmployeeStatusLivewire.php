<?php

namespace App\Livewire;

use App\Models\EmploymentStatus;
use Livewire\Component;

class EmployeeStatusLivewire extends Component
{
    public $data;
    public $show_modal = '';
    public $mode='';
    public $name, $id, $type, $duration, $description;
    
    public function mount()
    {
        $this->getEmployeeStatus();
    }

    public function getEmployeeStatus()
    {
        $this->data = EmploymentStatus::all();
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
                $data = EmploymentStatus::findOrFail($id);
                if (!$data) {
                    session()->flash('error', "Data not found");
                }
                $this->name = $data->name;
                $this->type = $data->type;
                $this->duration = $data->duration;
                $this->description = $data->description;
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
        $this->getEmployeeStatus();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->type = '';
        $this->duration = 0;
        $this->description = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'type' => 'required',
            'duration' => 'required',
            'description' => 'required',
        ]);

        $store = EmploymentStatus::create([
            'name' => $this->name,
            'type' => $this->type,
            'duration' => $this->duration,
            'description' => $this->description
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
            'name' => 'required',
            'type' => 'required',
            'duration' => 'required',
            'description' => 'required'
        ]);
        $update = EmploymentStatus::findOrFail($this->id)->update([
            'name' => $this->name,
            'type' => $this->type,
            'duration' => $this->duration,
            'description' => $this->description
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
        $delete = EmploymentStatus::findOrFail($id)->delete();
        if ($delete) {
            session()->flash('success', 'The data has been deleted successfully');
        } else {
            session()->flash('error', 'Failed to deleted the data. Please try again');
        }

        $this->getEmployeeStatus();
        $this->dispatch('reinitComponents');
    }

    public function render()
    {
        return view('pages.employe_status.index')->layout('layouts.app');
    }
}
