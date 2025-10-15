@section('title', 'Daily Attendance')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Attendance</span>
            <span>Daily Attendance</span>
        </div>
        <div class="az-content-label mg-b-5">Daily Attendance</div>
        <p class="mg-b-5">This menu is used to manage list of Daily Attendance.</p>

        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
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
                            <td>{{ $item->name }}</td>
                            <td>{{ $date }}</td>
                            <td>{{ $item->attendance->first()?->check_in ?? '-' }}</td>
                            <td>{{ $item->attendance->first()?->check_out ?? '-' }}</td>
                            <td>{{ $item->attendance->first()?->status ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->
</div>
