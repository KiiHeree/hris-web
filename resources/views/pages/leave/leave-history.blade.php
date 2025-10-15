@section('title', 'Leave History')
@extends('layouts.app-controller')
@section('content')
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Leave</span>
            <span>Leave History</span>
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
        <div class="az-content-label mg-b-5">Leave History</div>
        <p class="mg-b-5">This menu is used to manage list of Leave history.</p>

        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Approver</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->start_date }} - {{ $item->end_date }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->approver ? $item->approver->name : '-' }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('leave.leave.edit', $item->id) }}"
                                        class="btn btn-warning btn-icon mr-1"><i class="typcn typcn-edit"></i></a>
                                    <a href="{{ route('leave.leave.show', $item->id) }}"
                                        class="btn btn-primary btn-icon mr-1"><i class="typcn typcn-eye"></i></a>
                                    <form action="{{ route('leave.leave.destroy', $item->id) }}"
                                        enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon"><i
                                                class="typcn typcn-trash"></i></button>
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
