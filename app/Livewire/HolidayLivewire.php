<?php

namespace App\Livewire;

use App\Models\Holiday;
use Livewire\Component;

class HolidayLivewire extends Component
{
    public $data;
    public $show_modal = '';
    public $mode='';
    public $date, $id, $description;
    
    public function mount()
    {
        $this->getEmployeeStatus();
    }

    public function getEmployeeStatus()
    {
        $this->data = Holiday::all();
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
                $data = Holiday::findOrFail($id);
                if (!$data) {
                    session()->flash('error', "Data not found");
                }
                $this->date = $data->date;
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
        $this->date = '';
        $this->description = '';
    }

    public function store()
    {
        $this->validate([
            'date' => 'required',
            'description' => 'required',
        ]);

        $store = Holiday::create([
            'date' => $this->date,
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
            'date' => 'required',
            'description' => 'required'
        ]);
        $update = Holiday::findOrFail($this->id)->update([
            'date' => $this->date,
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
        $delete = Holiday::findOrFail($id)->delete();
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
        return view('pages.holiday.index')->layout('layouts.app');
    }
}
