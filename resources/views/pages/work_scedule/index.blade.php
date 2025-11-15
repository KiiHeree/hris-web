@section('title', 'Work Schedule')
@extends('layouts.app-controller')
@section('content')

    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Settings</span>
            <span>Work Schedule</span>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success" id="alertBox" style="position: absolute; top: 80px; right: 10px;" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" id="alertBox" style="position: absolute; top: 80px; right: 10px;" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="az-content-label mg-b-5">Work Schedule</div>
        <p class="mg-b-5">This menu is used to manage list of Work Schedule.</p>
        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Day</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->day_of_week }}</td>
                            <td>{{ $item->start_time ? $item->start_time : '-' }}</td>
                            <td>{{ $item->end_time ? $item->end_time : '-' }}</td>
                            <td>{{ $item->is_working_day ? 'Masuk' : 'Libur' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href=""
                                        class="btn btn-warning btn-icon mr-1"><i class="typcn typcn-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->


@endsection
