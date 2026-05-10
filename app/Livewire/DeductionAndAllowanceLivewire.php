<?php

namespace App\Livewire;

use App\Models\SalaryComponent;
use Livewire\Component;

class DeductionAndAllowanceLivewire extends Component
{
    public $data;
    public $show_modal = '';
    public $mode='';
    public $name, $id, $type, $calculation_type, $default_value;
    
    public function mount()
    {
        $this->getDeductionAllowance();
    }

    public function getDeductionAllowance()
    {
        $this->data = SalaryComponent::all();
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
                $data = SalaryComponent::findOrFail($id);
                if (!$data) {
                    session()->flash('error', "Data not found");
                }
                $this->name = $data->name;
                $this->type = $data->type;
                $this->calculation_type = $data->calculation_type;
                $this->default_value = $data->default_value;
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
        $this->getDeductionAllowance();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->type = '';
        $this->calculation_type = '';
        $this->default_value = 0;
    }

    public function updatedDefaultValue($value)
    {
        if ($this->calculation_type === 'percentage' && $value > 100) {
            $this->default_value = 100;
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'type' => 'required',
            'calculation_type' => 'required',
            'default_value' => 'required',
        ]);

        $store = SalaryComponent::create([
            'name' => $this->name,
            'type' => $this->type,
            'calculation_type' => $this->calculation_type,
            'default_value' => $this->default_value
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
            'calculation_type' => 'required',
            'default_value' => 'required'
        ]);
        $update = SalaryComponent::findOrFail($this->id)->update([
            'name' => $this->name,
            'type' => $this->type,
            'calculation_type' => $this->calculation_type,
            'default_value' => $this->default_value
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
        $delete = SalaryComponent::findOrFail($id)->delete();
        if ($delete) {
            session()->flash('success', 'The data has been deleted successfully');
        } else {
            session()->flash('error', 'Failed to deleted the data. Please try again');
        }

        $this->getDeductionAllowance();
        $this->dispatch('reinitComponents');
    }

    public function render()
    {
        return view('pages.deduction_allowance.index')->layout('layouts.app');
    }
}
