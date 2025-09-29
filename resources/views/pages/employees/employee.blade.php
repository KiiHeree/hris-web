@section('title', 'Employee Directory')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Employee</span>
            <span>Employee Directory</span>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success" id="alertBox" style="position: absolute; top: 80px; right: 10px;"
                role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" id="alertBox" style="position: absolute; top: 80px; right: 10px;"
                role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="az-content-label mg-b-5">Employee Directory</div>
        <p class="mg-b-5">This menu is used to manage list of Employee.</p>
        <button class="btn btn-primary btn-with-icon my-3 col-sm-4 col-md-2" type="button" data-toggle="modal"
            data-target="#modal" wire:click="showModal('create')"><i class="typcn typcn-edit"></i>
            Create</button>
        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Departement</th>
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->employee->department->name }}</td>
                            <td>{{ $item->employee->position->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-warning btn-icon mr-1"
                                        wire:click="showModal('update',{{ $item->id }})"><i
                                            class="typcn typcn-edit"></i></button>
                                    <a href="" class="btn btn-primary btn-icon mr-1"><i
                                            class="typcn typcn-eye"></i></a>
                                    <button class="btn btn-danger btn-icon" wire:click="delete({{ $item->id }})"><i
                                            class="typcn typcn-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->

    <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize" id="exampleModalLongTitle">{{ $mode }}
                        Department
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @if ($mode == 'create')
                    <form wire:submit.prevent="store">
                    @elseif ($mode == 'update')
                        <form wire:submit.prevent="update">
                @endif

                <div class="modal-body">
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">Name</label>
                        <input class="form-control" placeholder="Input Name" wire:model="name" type="text">
                    </div>
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">Email</label>
                        <input class="form-control" placeholder="Input Email" wire:model="email" type="email">
                    </div>
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">Password</label>
                        <input class="form-control" placeholder="Input Password" wire:model="password" type="text">
                    </div>

                    {{-- Employee Detail --}}
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">NIK</label>
                        <input class="form-control" placeholder="Input NIK" wire:model="nik" type="text">
                    </div>
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">Join Date</label>
                        <input class="form-control" wire:model="join_date" type="date">
                    </div>
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">Department</label>
                        <select class="form-control" wire:model="department_id">
                            <option value="">== Pilih Department ==</option>
                            @foreach ($department as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">Position</label>
                        <select class="form-control" wire:model="position_id">
                            <option value="">== Pilih Position ==</option>
                            @foreach ($position as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">Salary Basic</label>
                        <input class="form-control" placeholder="Input Salary Basic" wire:model="salary_basic"
                            type="number">
                    </div>
                    <div class="form-group has-success">
                        <label for="exampleInputEmail1">Bank Account</label>
                        <input class="form-control" placeholder="Input Bank Account" wire:model="bank_account"
                            type="text">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
