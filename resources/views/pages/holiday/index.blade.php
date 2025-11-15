@section('title', 'Holiday')
@extends('layouts.app-controller')
@section('content')

    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Settings</span>
            <span>Holiday</span>
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
        <div class="az-content-label mg-b-5">Holiday</div>
        <p class="mg-b-5">This menu is used to manage list of Holiday.</p>
        <a class="btn btn-primary btn-with-icon my-3 col-sm-4 col-md-2" href="{{ route('setting.holiday.create') }}"><i
                class="typcn typcn-edit"></i>
            Create</a>
        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('setting.holiday.edit', $item->id) }}"
                                        class="btn btn-warning btn-icon mr-1"><i class="typcn typcn-edit"></i></a>
                                    <form action="{{ route('setting.holiday.destroy', $item->id) }}"
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
