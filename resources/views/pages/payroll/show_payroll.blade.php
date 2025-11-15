@section('title', 'Show Payroll')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        <div class="az-content-breadcrumb">
            <span>Payroll</span>
            <span>Show Payroll</span>
        </div>
        <div class="az-content-label mg-b-5">Show Payroll</div>
        <p class="mg-b-5">This menu is used to manage list of Payroll.</p>

        <div class="mt-2">
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Employee Name</label>
                <input class="form-control" type="text" value="{{ $payroll->employee->name }}">
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Salary Basic</label>
                <input class="form-control" class="form-control" type="text" value="{{ number_format($payroll->salary_basic) }}">
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Salary Net</label>
                <input class="form-control" class="form-control" type="text" value="{{ number_format($payroll->net) }}">
            </div>
            <div class="form-group has-success">
                <label for="exampleInputEmail1">Status</label>
                <input class="form-control" class="form-control" type="text" value="{{ $payroll->status }}">
            </div>
        </div>

        <div class="table-responsive mt-2">
            <table class="table table-bordered mg-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payroll->items as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ number_format($item->amount) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{url()->previous()}}" class="btn btn-outline-secondary mt-2">Kembali</a>
    </div>
</div>
