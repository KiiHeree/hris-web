@section('title', 'Payroll Management')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Payroll</span>
            <span>Payroll Management</span>
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

        <div class="az-content-label mg-b-5">Payroll Management</div>
        <p class="mg-b-5">This menu is used to manage list of Payroll Management.</p>

        <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee</th>
                        <th>Period</th>
                        <th>Salary Basic</th>
                        <th>Net</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->employee->full_name }}</td>
                            <td>{{ $item->period }}</td>
                            <td>{{ number_format($item->salary_basic) }}</td>
                            <td>{{ number_format($item->net_salary) }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <div class="d-flex">
                                    @if ($item->status == 'draft')
                                        <button wire:click="approve_payroll({{ $item->id }})"
                                            class="btn btn-success btn-icon mr-1"><i
                                                class="typcn typcn-input-checked"></i>
                                        </button>
                                    @endif
                                    <a href="{{route('payroll.show_payroll',$item->id)}}" class="btn btn-primary btn-icon mr-1">
                                        <i class="typcn typcn-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- az-content-body -->
</div>
