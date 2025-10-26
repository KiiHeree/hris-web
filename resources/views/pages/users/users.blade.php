@section('title', 'Users')
@extends('layouts.app-controller')
@section('content')
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Settings</span>
            <span>Users Directory</span>
        </div>
       
        <div class="az-content-label mg-b-5">Users Directory</div>
        <p class="mg-b-5">This menu is used to manage list of Users.</p>
        {{-- <a class="btn btn-primary btn-with-icon my-3 col-sm-4 col-md-2" href="{{ route('employee.employee.create') }}"><i
                class="typcn typcn-edit"></i>
            Create</a> --}}
        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->roles->first()->name }}</td>
                            {{-- <td>
                                <div class="d-flex">
                                    <a href="{{ route('employee.employee.edit', $item->id) }}"
                                        class="btn btn-warning btn-icon mr-1"><i class="typcn typcn-edit"></i></a>
                                    <a href="{{ route('employee.employee.show', $item->id) }}"
                                        class="btn btn-primary btn-icon mr-1"><i class="typcn typcn-eye"></i></a>
                                    <form action="{{ route('employee.employee.destroy', $item->id) }}"
                                        enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon"><i
                                                class="typcn typcn-trash"></i></button>
                                    </form>

                                </div>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->
@endsection
