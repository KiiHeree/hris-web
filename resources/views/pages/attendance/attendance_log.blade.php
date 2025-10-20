@section('title', 'Attendance Log')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Attendance</span>
            <span>Attendance Log</span>
        </div>
        <div class="az-content-label mg-b-5">Attendance Log</div>
        <p class="mg-b-5">This menu is used to manage list of Attendance Log.</p>
        <form wire:submit.prevent="filter" class="mt-2">
            <div class="row row-sm mb-2">
                <div class="col-lg">
                    <label for="exampleInputEmail1">Employee</label>
                    <select class="form-control" wire:model="employee_id">
                        <option value="">== Pilih Employee ==</option>
                        @foreach ($employee as $item)
                            <option value="{{$item->id}}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div><!-- col -->
                <div class="col-lg mg-t-10 mg-lg-t-0">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input class="form-control" wire:model="start_date" type="date" value="{{ old('start_date') }}">
                </div><!-- col -->
                <div class="col-lg mg-t-10 mg-lg-t-0">
                    <label for="exampleInputEmail1">End Date</label>
                    <input class="form-control" wire:model="end_date" type="date" value="{{ old('end_date') }}">
                </div><!-- col -->
            </div>
            <button type="submit" class="btn btn-outline-success">Filter</button>
        </form>
        @if ($data)
            <div class="table-responsive mt-2">
                <table class="table table-bordered mg-b-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->check_in  }}</td>
                                <td>{{ $item->check_out  }}</td>
                                <td>{{ $item->status  }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- table-responsive -->
        @else
            <div class="mt-3">
                <p class="mg-b-5">Please select an employee to view attendance logs.</p>
            </div>
        @endif
    </div><!-- az-content-body -->
</div>
