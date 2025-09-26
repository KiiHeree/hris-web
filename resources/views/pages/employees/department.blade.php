@section('title', 'Department')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Employee</span>
            <span>Department</span>
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
        <div class="az-content-label mg-b-5">Department</div>
        <p class="mg-b-5">This menu is used to manage list of department/division in the company.</p>
        <button class="btn btn-primary btn-with-icon my-3 col-sm-4 col-md-2" wire:click="showModal('create')"><i
                class="typcn typcn-edit"></i> Create</button>
        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-warning btn-icon mr-1"
                                        wire:click="showModal('update',{{ $item->id }})"><i
                                            class="typcn typcn-edit"></i></button>
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

    <div class="modal fade {{ $show_modal ? 'show' : '' }}" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" style="display: {{ $show_modal ? 'block' : 'none' }};">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize" id="exampleModalLongTitle">{{ $mode }} Department
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
                        <input class="form-control" placeholder="Input Name" wire:model="name" required="name"
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
