@section('title', 'Leave Show')
@extends('layouts.app-controller')
@section('content')
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Leave</span>
            <span>Leave Show</span>
        </div>
        <div class="az-content-label mg-b-5">Show</div>
        <p class="mg-b-5">This menu is used to manage list of Employee.</p>

        <form action="" style="margin-top: 20px; padding: 10px" class="card">
            <div class="form-group has-success">
                <label for="">Deskripsi</label>
                <textarea class="form-control" placeholder="Input Deskripsi" disabled name="deskripsi" type="text">{{ old('deskripsi', $data ? $data->deskripsi : '') }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Start Date</label>
                <input type="date" disabled name="start_date" class="form-control"
                    value="{{ old('start_date', $data ? $data->start_date : '') }}">
            </div>
            <div class="form-group">
                <label for="">Start Date</label>
                <input type="date" disabled name="end_date" class="form-control"
                    value="{{ old('end_date', $data ? $data->end_date : '') }}">
            </div>

            <div class="form-group has-success">
                <label for="">Type</label>
                <select class="form-control" disabled name="type">
                    <option value="">== Pilih Type ==</option>
                    @foreach ($type as $item)
                        <option value="{{ $item }}"
                            {{ old('type', $data ? ($data->type == $item ? 'selected' : '') : '') }}
                            style="text-transform: capitalize">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>
        </form>
    </div>
@endsection
