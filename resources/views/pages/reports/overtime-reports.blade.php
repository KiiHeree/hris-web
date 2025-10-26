@section('title', 'Overtime Reports')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Reports</span>
            <span>Overtime Reports</span>
        </div>
       
        <div class="az-content-label mg-b-5">Overtime Reports</div>
        <p class="mg-b-5">This menu is used to manage list of Overtime Reports.</p>

        <div class="table-responsive">
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
                            <td>{{ $item->start_time }} -> {{$item->end_time}}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->total_hours }}</td>
                            <td>{{ $item->approver->name }}</td>/
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->
</div>
