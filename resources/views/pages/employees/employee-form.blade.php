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

        <form action="{{ $data ? route('employee.employee.update', $data->user_id) : route('employee.employee.store') }}"
            style="margin-top: 20px;" enctype="multipart/form-data" method="POST">
            @csrf
            @if ($data)
                @method('PUT')
            @endif

            {{-- Card: Employee Info --}}
            <div class="card pd-20 mg-b-20">
                <h6 class="az-content-label mg-b-15">Employee Information</h6>
                <div class="form-group">
                    <label>Full Name</label>
                    <input class="form-control" placeholder="Input Full Name" name="full_name" type="text"
                        value="{{ old('full_name', $data?->full_name) }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" placeholder="Input Name" name="name" type="text"
                                value="{{ old('name', $data?->user?->name) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="">== Select Gender ==</option>
                                <option value="L" {{ old('gender', $data?->gender) == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                                <option value="P" {{ old('gender', $data?->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Birth Place</label>
                            <input class="form-control" placeholder="Input Birth Place" name="birth_place" type="text"
                                value="{{ old('birth_place', $data?->birth_place) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Birth Date</label>
                            <input class="form-control" name="birth_date" type="date"
                                value="{{ old('birth_date', $data?->birth_date) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" placeholder="Input Email" name="email" type="email"
                                value="{{ old('email', $data?->user?->email) }}">
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
                                value="{{ old('nik', $data?->nik) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Join Date</label>
                            <input class="form-control" name="join_date" type="date"
                                value="{{ old('join_date', $data?->join_date) }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input class="form-control" placeholder="Input Address" name="address" type="text"
                        value="{{ old('address', $data?->address) }}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Department</label>
                            <select class="form-control" name="department_id">
                                <option value="">== Pilih Department ==</option>
                                @foreach ($department as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('department_id', $data?->department_id) == $item->id ? 'selected' : '' }}>
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
                                        {{ old('position_id', $data?->position_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Salary Basic</label>
                            <input class="form-control" placeholder="Input Salary Basic" name="salary_basic" type="number" id="salary_basic"
                                value="{{ old('salary_basic', $data?->salary_basic) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bank Name</label>
                            <input class="form-control" placeholder="Input Bank Name" name="bank_name" type="text"
                                value="{{ old('bank_name', $data?->bank_name) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bank Account</label>
                            <input class="form-control" placeholder="Input Bank Account" name="bank_account" type="text"
                                value="{{ old('bank_account', $data?->bank_account) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NPWP</label>
                            <input class="form-control" placeholder="Input NPWP" name="npwp" type="text"
                                value="{{ old('npwp', $data?->npwp) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telp</label>
                            <input class="form-control" placeholder="Input Telp" name="telp" type="number"
                            value="{{ old('telp', $data?->telp) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Manager</label>
                            <select class="form-control" name="manager_id">
                                <option value="">== Pilih Manager ==</option>
                                @foreach ($manager as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('manager_id', $data?->manager_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="employment_status_id">
                                <option value="">== Pilih Status ==</option>
                                @foreach ($status as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('position_id', $data?->employment_status_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" placeholder="Input Notes" name="notes" >{{ old('notes', $data?->notes) }}</textarea>
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
                                    <th>Salary Component</th>
                                    <th>Amount</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody id="salary-rows">
                                @forelse ($detail_salary as $i => $item)
                                    <tr id="salary-row-{{ $i }}">
                                        <td>
                                            {{ $item->salaryComponent->type }} - {{ $item->salaryComponent->name }}
                                            <input type="hidden" name="salary_components[{{ $i }}][id]" value="{{ $item->id }}">
                                            <input type="hidden" name="salary_components[{{ $i }}][type]" value="{{ $item->salary_component_id }}">
                                        </td>
                                        <td>
                                            {{ number_format($item->value, 0, ',', '.') }}
                                            <input type="hidden" name="salary_components[{{ $i }}][amount]" value="{{ $item->value }}">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger btn-remove-salary" data-index="{{ $i }}">
                                                &times;
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="salary-empty">
                                        <td colspan="3" class="text-center text-muted">No salary components added yet</td>
                                    </tr>
                                @endforelse
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
                                    <th>Type</th>
                                    <th>File</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody id="document-rows">
                                @forelse ($detail_document as $i => $item)
                                    <tr id="document-row-{{ $i }}">
                                        <td>
                                            {{ $item->type }}
                                            <input type="hidden" name="documents[{{ $i }}][id]" value="{{ $item->id }}">
                                            <input type="hidden" name="documents[{{ $i }}][type]" value="{{ $item->type }}">
                                        </td>
                                        <td>{{ $item->file_path }}</td>
                                        <input type="hidden" name="documents[{{ $i }}][existing_file]" value="{{ $item->file_path }}">
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger btn-remove-document" data-index="{{ $i }}">
                                                &times;
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="document-empty">
                                        <td colspan="3" class="text-center text-muted">No documents uploaded yet</td>
                                    </tr>
                                @endforelse
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
                        <label>Salary Component</label>
                        <select class="form-control" id="salary-type">
                            <option value="">== Select Type ==</option>
                            @foreach ($salary_component as $data)
                                <option value="{{ $data->id }}" data-label="{{ $data->type }} - {{ $data->name }}" data-calc="{{ $data->calculation_type }}" data-value="{{ $data->default_value }}">
                                    {{ $data->type }} - {{ $data->name }} | {{ $data->calculation_type }} - {{ $data->default_value }}
                                </option>
                            @endforeach
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
        let salaryIndex = {{ count($detail_salary) }};;
        let documentIndex = {{ count($detail_document) }};;

        $('#btn-add-salary').on('click', function () {
            $('#salary-type').val('');
            $('#salary-amount').val('');
            $('#modalSalary').modal('show');
        });

        $('#btn-add-document').on('click', function () {
            $('#doc-type').val('');
            $('#doc-file').val('');
            $('#modalDocument').modal('show');
        });

        $('#btn-save-salary').on('click', function () {
            const type   = $('#salary-type').val();
            const typeLabel = $('#salary-type option:selected').data('label');
            const amount = $('#salary-amount').val().trim();

            if (!type || !amount) {
                alert('Please fill all fields.');
                return;
            }

            $('#salary-empty').hide();
            $('#salary-rows').append(`
                <tr id="salary-row-${salaryIndex}">
                    <td>
                        ${typeLabel}
                        <input type="hidden" name="salary_components[${salaryIndex}][id]" value="">
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

        // iki ben otomatis set field amount
        $('#salary-type').on('change', function () {
            const selected = $(this).find('option:selected');
            const calcType = selected.data('calc');
            const defValue = parseFloat(selected.data('value')) || 0;
            const basicSalary = parseFloat($('input[name="salary_basic"]').val()) || 0;

            let amount = 0;
            if (calcType === 'percentage') {
                amount = (basicSalary * defValue) / 100;
            } else {
                amount = defValue;
            }

            $('#salary-amount').val(amount);
        });

        $('#btn-save-document').on('click', function () {
            const type = $('#doc-type').val();
            const file = $('#doc-file')[0].files[0];

            if (!type || !file) {
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
                        ${type}
                        <input type="hidden" name="documents[${documentIndex}][id]" value="">
                        <input type="hidden" name="documents[${documentIndex}][type]" value="${type}">
                        <input type="hidden" name="documents[${documentIndex}][existing_file]" value="">
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