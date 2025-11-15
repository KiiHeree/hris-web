@section('title', 'Holiday Form')
@extends('layouts.app-controller')
@section('content')
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Settings</span>
            <span>Holiday</span>
            <span>Holiday Form</span>
        </div>
        <div class="az-content-label mg-b-5">{{ $title }}</div>
        <p class="mg-b-5">This menu is used to manage list of Holiday.</p>

        <form action="{{ $data ? route('setting.holiday.update', $data->id) : route('setting.holiday.store') }}"
            style="margin-top: 20px; padding: 10px" class="card" enctype="multipart/form-data"
            method="POST">
            @csrf
            @if ($data)
                @method('PUT')
            @endif
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Date</label>
                <input class="form-control" placeholder="Input Date" name="date" type="date"
                    value="{{ old('date', $data ? $data->date : '') }}">
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Description</label>
                <input class="form-control" placeholder="Input Description" name="description" type="text"
                    value="{{ old('description', $data ? $data->description : '') }}">
            </div>
            <button type="submit" class="btn btn-primary">{{ $data ? 'Update' : 'Create' }}</button>
        </form>
    </div>
@endsection
