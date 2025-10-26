@section('title', 'Overtime Request')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Attendance</span>
            <span>Overtime Request</span>
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
        <div class="az-content-label mg-b-5">Overtime Request</div>
        <p class="mg-b-5">This menu is used to manage list of Overtime Request.</p>

        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Hours</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->employee->name }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->total_hours }}</td>
                            <td>
                                <div class="d-flex">
                                    {{-- <a href="{{ route('leave.leave.show', $item->id) }}"
                                        class="btn btn-primary btn-icon mr-1"><i class="typcn typcn-eye"></i></a> --}}
                                    <button type="submit" class="btn btn-success btn-icon mr-2"
                                        wire:click="overtime_approve('approved',{{ $item->id }})"><i
                                            class="typcn typcn-tick" onclick="confirm('Are you sure ?')"></i></button>
                                    <button type="submit" class="btn btn-danger btn-icon"  wire:click="overtime_approve('rejected',{{ $item->id }})"><i class="typcn typcn-times"
                                            onclick="confirm('Are you sure ?')"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->
</div>
