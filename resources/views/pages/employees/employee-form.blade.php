@section('title', 'Employee Form')
@extends('layouts.app-controller')
@section('content')
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        @if (Session::has('error'))
            <div class="alert alert-danger" id="alertBox" style="position: absolute; top: 80px; right: 10px;" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="az-content-breadcrumb">
            <span>Employee</span>
            <span>Employee Directory</span>
            <span>Employee Form</span>
        </div>
        <div class="az-content-label mg-b-5">{{ $title }}</div>
        <p class="mg-b-5">This menu is used to manage list of Employee.</p>

        <form action="{{ $data ? route('employee.employee.update', $data->id) : route('employee.employee.store') }}"
            style="margin-top: 20px;" enctype="multipart/form-data" method="POST">
            @csrf
            @if ($data)
                @method('PUT')
            @endif

            {{-- Card: Employee Info --}}
            <div class="card pd-20 mg-b-20">
                <h6 class="az-content-label mg-b-15">Employee Information</h6>
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" placeholder="Input Name" name="name" type="text"
                        value="{{ old('name', $data?->name) }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" placeholder="Input Email" name="email" type="email"
                                value="{{ old('email', $data?->email) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" placeholder="Input Password" name="password" type="password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NIK</label>
                            <input class="form-control" placeholder="Input NIK" name="nik" type="text"
                                value="{{ old('nik', $data?->employee?->nik) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Join Date</label>
                            <input class="form-control" name="join_date" type="date"
                                value="{{ old('join_date', $data?->employee?->join_date) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Department</label>
                            <select class="form-control" name="department_id">
                                <option value="">== Pilih Department ==</option>
                                @foreach ($department as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('department_id', $data?->employee?->department_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Position</label>
                            <select class="form-control" name="position_id">
                                <option value="">== Pilih Position ==</option>
                                @foreach ($position as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('position_id', $data?->employee?->position_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Salary Basic</label>
                            <input class="form-control" placeholder="Input Salary Basic" name="salary_basic" type="number"
                                value="{{ old('salary_basic', $data?->employee?->salary_basic) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bank Account</label>
                            <input class="form-control" placeholder="Input Bank Account" name="bank_account" type="text"
                                value="{{ old('bank_account', $data?->employee?->bank_account) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{--Tabs Salary Component & Document --}}
            <div class="card pd-20 mg-b-20">
                <ul class="nav nav-tabs mg-b-20" id="employeeTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-salary">Salary Component</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-document">Document</a>
                    </li>
                </ul>

                <div class="tab-content">
                    {{-- Tab Salary Component --}}
                    <div class="tab-pane fade show active" id="tab-salary">
                        <button type="button" class="btn btn-sm btn-outline-primary mg-b-15" id="btn-add-salary">
                            + Add Salary
                        </button>
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Component Name</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody id="salary-rows">
                                <tr id="salary-empty">
                                    <td colspan="4" class="text-center text-muted">No salary components added yet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Tab Document --}}
                    <div class="tab-pane fade" id="tab-document">
                        <button type="button" class="btn btn-sm btn-outline-primary mg-b-15" id="btn-add-document">
                            + Add Document
                        </button>
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Document Name</th>
                                    <th>Type</th>
                                    <th>File</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody id="document-rows">
                                <tr id="document-empty">
                                    <td colspan="4" class="text-center text-muted">No documents uploaded yet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-end mg-b-20" style="gap: 10px;">
            <a href="{{ route('employee.employee.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">{{ $data ? 'Update' : 'Create' }}</button>
        </div>
    </form>

    {{-- Modal Salary Component --}}
    <div class="modal fade" id="modalSalary" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add Salary Component</h6>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Component Name</label>
                        <input type="text" class="form-control" id="salary-name" placeholder="e.g. Transport Allowance">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" id="salary-type">
                            <option value="">== Select Type ==</option>
                            <option value="Allowance">Allowance</option>
                            <option value="Deduction">Deduction</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" id="salary-amount" placeholder="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btn-save-salary">Add</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Document --}}
    <div class="modal fade" id="modalDocument" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add Document</h6>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Document Name</label>
                        <input type="text" class="form-control" id="doc-name" placeholder="e.g. KTP">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" id="doc-type">
                            <option value="">== Select Type ==</option>
                            <option value="Identity">Identity</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Contract">Contract</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" class="form-control" id="doc-file">
                        <small class="text-muted">Accepted: JPG, PNG, PDF (max 2MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btn-save-document">Add</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        let salaryIndex = 0;
        let documentIndex = 0;

        $('#btn-add-salary').on('click', function () {
            $('#salary-name').val('');
            $('#salary-type').val('');
            $('#salary-amount').val('');
            $('#modalSalary').modal('show');
        });

        $('#btn-add-document').on('click', function () {
            $('#doc-name').val('');
            $('#doc-type').val('');
            $('#doc-file').val('');
            $('#modalDocument').modal('show');
        });

        $('#btn-save-salary').on('click', function () {
            const name   = $('#salary-name').val().trim();
            const type   = $('#salary-type').val();
            const amount = $('#salary-amount').val().trim();

            if (!name || !type || !amount) {
                alert('Please fill all fields.');
                return;
            }

            $('#salary-empty').hide();
            $('#salary-rows').append(`
                <tr id="salary-row-${salaryIndex}">
                    <td>
                        ${name}
                        <input type="hidden" name="salary_components[${salaryIndex}][name]" value="${name}">
                    </td>
                    <td>
                        ${type}
                        <input type="hidden" name="salary_components[${salaryIndex}][type]" value="${type}">
                    </td>
                    <td>
                        ${Number(amount).toLocaleString('id-ID')}
                        <input type="hidden" name="salary_components[${salaryIndex}][amount]" value="${amount}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-remove-salary" data-index="${salaryIndex}">
                            &times;
                        </button>
                    </td>
                </tr>
            `);

            salaryIndex++;
            $('#modalSalary').modal('hide');
        });

        $('#btn-save-document').on('click', function () {
            const name = $('#doc-name').val().trim();
            const type = $('#doc-type').val();
            const file = $('#doc-file')[0].files[0];

            if (!name || !type || !file) {
                alert('Please fill all fields.');
                return;
            }

            const dt = new DataTransfer();
            dt.items.add(file);
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = `documents[${documentIndex}][file]`;
            fileInput.files = dt.files;
            fileInput.style.display = 'none';
            document.querySelector('form').appendChild(fileInput);

            $('#document-empty').hide();
            $('#document-rows').append(`
                <tr id="document-row-${documentIndex}">
                    <td>
                        ${name}
                        <input type="hidden" name="documents[${documentIndex}][name]" value="${name}">
                    </td>
                    <td>
                        ${type}
                        <input type="hidden" name="documents[${documentIndex}][type]" value="${type}">
                    </td>
                    <td>${file.name}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-remove-document" data-index="${documentIndex}">
                            &times;
                        </button>
                    </td>
                </tr>
            `);

            documentIndex++;
            $('#modalDocument').modal('hide');
        });

        $(document).on('click', '.btn-remove-salary', function () {
            const i = $(this).data('index');
            $(`#salary-row-${i}`).remove();
            if ($('#salary-rows tr:visible').length === 0) $('#salary-empty').show();
        });

        $(document).on('click', '.btn-remove-document', function () {
            const i = $(this).data('index');
            $(`#document-row-${i}`).remove();
            if ($('#document-rows tr:visible').length === 0) $('#document-empty').show();
        });
    });
</script>
@endsection