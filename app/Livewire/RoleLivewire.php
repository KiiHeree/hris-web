<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleLivewire extends Component
{
    public $data, $permissions, $show_modal = false, $mode = '';
    public $name, $role_id, $selected_permissions = [];

    public function mount()
    {
        $this->getRole();
        $this->permissions = Permission::all(); // buat select multiple permission
    }

    public function getRole()
    {
        $this->data = Role::with('permissions')->get();
    }

    public function showModal($mode, $id = null)
    {
        $this->mode = $mode;
        $this->show_modal = true;

        if ($mode === 'create') {
            $this->resetForm();
        } elseif ($mode === 'update' && $id) {
            $this->role_id = $id;
            $role = Role::with('permissions')->find($id);

            if (!$role) {
                session()->flash('role_error', "Role not found");
                $this->closeModal();
                return;
            }

            $this->name = $role->name;
            $this->selected_permissions = $role->permissions->pluck('id')->toArray();
        }
    }

    public function closeModal()
    {
        $this->show_modal = false;
        $this->resetForm();
        $this->dispatch('reinitComponents');
        $this->getRole();
    }

    public function resetForm()
    {
        $this->role_id = null;
        $this->name = '';
        $this->selected_permissions = [];
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $role = Role::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);

        if ($role) {
            $role->syncPermissions($this->selected_permissions);
            session()->flash('success', 'Role has been created successfully');
        } else {
            session()->flash('error', 'Failed to create role');
        }

        $this->closeModal();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->role_id
        ]);

        $role = Role::findOrFail($this->role_id);
        $update = $role->update([
            'name' => $this->name
        ]);

        if ($update) {
            $role->syncPermissions($this->selected_permissions);
            session()->flash('success', 'Role has been updated successfully');
        } else {
            session()->flash('error', 'Failed to update role');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        $delete = Role::findOrFail($id)->delete();

        if ($delete) {
            session()->flash('success', 'Role has been deleted successfully');
        } else {
            session()->flash('error', 'Failed to delete role');
        }

        $this->getRole();
        $this->dispatch('reinitComponents');
    }

    public function render()
    {
        return view('pages.role & permission.role')->layout('layouts.app');
    }
}
