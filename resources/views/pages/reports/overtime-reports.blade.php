@section('title', 'Overtime Reports')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Reports</span>
            <span>Overtime Reports</span>
        </div>

        <div class="az-content-label mg-b-5">Overtime Reports</div>
        <p class="mg-b-5">This menu is used to manage list of Overtime Reports.</p>
        <form wire:submit.prevent="filter" class="mt-2">
            <div class="row row-sm mb-2">
                <div class="col-lg">
                    <label for="exampleInputEmail1">Employee</label>
                    <select class="form-control" wire:model="employee_id">
                        <option value="">== Pilih Employee ==</option>
                        @foreach ($employee as $item)
                            <option value="{{ $item->id }}">
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
        <div class="table-responsive mt-2">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Hours Total</th>
                        <th>Approver</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->employee->name }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->start_time }} -> {{ $item->end_time }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->total_hours }}</td>
                            <td>{{ $item->approver ? $item->approver->name : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->
</div>
