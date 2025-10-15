@section('title', 'Leave Approval')
@extends('layouts.app-controller')
@section('content')
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Leave</span>
            <span>Leave Approval</span>
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
        <div class="az-content-label mg-b-5">Leave Approval</div>
        <p class="mg-b-5">This menu is used to manage list of Leave Approval.</p>

        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->employee->name }}</td>
                            <td>{{ $item->start_date }} - {{ $item->end_date }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('leave.leave.show', $item->id) }}"
                                        class="btn btn-primary btn-icon mr-1"><i class="typcn typcn-eye"></i></a>
                                    <form action="{{ route('leave.approve', $item->id) }}" enctype="multipart/form-data"
                                        method="POST" class="mr-1">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-icon" name="status" value="approved"><i
                                                class="typcn typcn-tick" onclick="confirm('Are you sure ?')"></i></button>
                                    </form>
                                    <form action="{{ route('leave.approve', $item->id) }}" enctype="multipart/form-data"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-icon" name="status" value="rejected"><i
                                                class="typcn typcn-times" onclick="confirm('Are you sure ?')"></i></button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->
@endsection
