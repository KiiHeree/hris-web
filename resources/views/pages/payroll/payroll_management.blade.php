@section('title', 'Payroll Management')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="background:none; padding:0;">
                <li class="breadcrumb-item text-muted">Payroll</li>
                <li class="breadcrumb-item active">Payroll Management</li>
            </ol>
        </nav>

        {{-- Alert --}}
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" id="alertBox" role="alert">
                <i class="typcn typcn-tick mr-2"></i>{{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" id="alertBox" role="alert">
                <i class="typcn typcn-times mr-2"></i>{{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold mb-1">Payroll Management</h4>
                <p class="text-muted mb-0" style="font-size:13px;">Kelola data penggajian karyawan</p>
            </div>
        </div>

        {{-- Card Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#f8f9fc;">
                            <tr>
                                <th class="border-0 px-4 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">No</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Employee</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Period</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Salary Basic</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Net Salary</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Status</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="px-4 align-middle" style="font-size:13px;">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-2"
                                                style="width:34px; height:34px; background:#e8e3ff; color:#6c3fdf; font-weight:600; font-size:13px; flex-shrink:0;">
                                                {{ strtoupper(substr($item->employee->full_name, 0, 1)) }}
                                            </div>
                                            <span style="font-size:13px; font-weight:500;">{{ $item->employee->full_name }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle" style="font-size:13px;">
                                        <i class="typcn typcn-calendar text-muted mr-1"></i>{{ $item->period }}
                                    </td>
                                    <td class="align-middle" style="font-size:13px;">
                                        Rp {{ number_format($item->salary_basic) }}
                                    </td>
                                    <td class="align-middle" style="font-size:13px; font-weight:600; color:#2d3748;">
                                        Rp {{ number_format($item->net_salary) }}
                                    </td>
                                    <td class="align-middle">
                                        @if ($item->status == 'paid')
                                            <span class="badge badge-pill px-3 py-1"
                                                style="background:#d4edda; color:#155724; font-size:11px;">
                                                <i class="typcn typcn-tick mr-1"></i>Paid
                                            </span>
                                        @else
                                            <span class="badge badge-pill px-3 py-1"
                                                style="background:#fff3cd; color:#856404; font-size:11px;">
                                                <i class="typcn typcn-pencil mr-1"></i>Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center" style="gap:6px;">
                                            @if ($item->status == 'draft')
                                                <button wire:click="approve_payroll({{ $item->id }})"
                                                    class="btn btn-sm btn-success d-flex align-items-center"
                                                    style="border-radius:6px; font-size:12px; padding:4px 10px;">
                                                    <i class="typcn typcn-input-checked mr-1"></i> Approve
                                                </button>
                                            @endif
                                            <a href="{{ route('payroll.show_payroll', $item->id) }}"
                                                class="btn btn-sm btn-primary d-flex align-items-center"
                                                style="border-radius:6px; font-size:12px; padding:4px 10px;">
                                                <i class="typcn typcn-eye mr-1"></i> Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="typcn typcn-document" style="font-size:32px;"></i>
                                        <p class="mt-2 mb-0">Belum ada data payroll</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>