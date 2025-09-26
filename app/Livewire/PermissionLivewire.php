<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionLivewire extends Component
{
    public $data, $show_modal = false, $mode = '';
    public $name, $id;

    public function mount()
    {
        $this->getPermission();
    }

    public function getPermission()
    {
        $this->data = Permission::all();
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
                $data = Permission::findOrFail($id);
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
        $this->getPermission();
    }

    public function resetForm()
    {
        $this->name = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        $store = Permission::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);

        if ($store) {
            session()->flash('success', 'Permission has been created successfully');
        } else {
            session()->flash('error', 'Failed to create permission. Please try again');
        }

        $this->closeModal();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        $permission = Permission::findOrFail($this->id);
        $update = $permission->update([
            'name' => $this->name
        ]);

        if ($update) {
            session()->flash('success', 'Permission has been updated successfully');
        } else {
            session()->flash('error', 'Failed to update permission. Please try again');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $delete = Permission::findOrFail($id)->delete();

        if ($delete) {
            session()->flash('success', 'Permission has been deleted successfully');
        } else {
            session()->flash('error', 'Failed to delete permission. Please try again');
        }

        $this->getPermission();
        $this->dispatch('reinitComponents');
    }


    public function render()
    {
        return view('pages.role & permission.permission')->layout('layouts.app');
    }
}
