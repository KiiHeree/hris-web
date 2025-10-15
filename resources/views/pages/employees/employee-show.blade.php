@section('title', 'Employee Form')
@extends('layouts.app-controller')
@section('content')
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Employee</span>
            <span>Employee Directory</span>
            <span>Employee Show</span>
        </div>
        <div class="az-content-label mg-b-5">Show Employee</div>
        <p class="mg-b-5">This menu is used to manage list of Employee.</p>

        <form action="" style="margin-top: 20px; padding: 10px" class="card" enctype="multipart/form-data">

            <div class="form-group has-success">
                <label for="exampleInputEmail1">Name</label>
                <input class="form-control" placeholder="Input Name" name="name" type="text"
                    value="{{ old('name', $data ? $data->name : '') }} " disabled>
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Email</label>
                <input class="form-control" placeholder="Input Email" name="email" type="email"
                    value="{{ old('email', $data ? $data->email : '') }} " disabled>
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Password</label>
                <input class="form-control" placeholder="Input Password" name="password" type="text" disabled>
            </div>

            {{-- Employee Detail --}}
            <div class="form-group has-success">
                <label for="exampleInputEmail1">NIK</label>
                <input class="form-control" placeholder="Input NIK" name="nik" type="text"
                    value="{{ old('nik', $data ? $data->employee->nik : '') }} " disabled>
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Join Date</label>
                <input class="form-control" name="join_date" type="date"
                    value="{{ old('join_date', $data ? $data->employee->join_date : '') }} " disabled>
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Department</label>
                <select class="form-control" name="department_id" disabled>
                    <option value="">== Pilih Department ==</option>
                    @foreach ($department as $item)
                        <option value="{{ $item->id }}"
                            {{ old('position_id', $data ? ($data->employee->department_id == $item->id ? 'selected' : '') : '') }}>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Position</label>
                <select class="form-control" name="position_id" disabled>
                    <option value="">== Pilih Position ==</option>
                    @foreach ($position as $item)
                        <option value="{{ $item->id }}"
                            {{ old('position_id', $data ? ($data->employee->position_id == $item->id ? 'selected' : '') : '') }}>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Salary Basic</label>
                <input class="form-control" placeholder="Input Salary Basic" name="salary_basic" type="number"
                    value="{{ $data->employee->salary_basic }}" disabled>
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Bank Account</label>
                <input class="form-control" placeholder="Input Bank Account" name="bank_account" type="text"
                    value="{{ old('bank_account', $data ? $data->employee->bank_account : '') }} " disabled>
            </div>
            <a href="{{ route('employee.employee.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </form>
    </div>
@endsection
