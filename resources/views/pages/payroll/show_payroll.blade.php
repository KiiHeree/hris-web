@section('title', 'Show Payroll')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="background:none; padding:0;">
                <li class="breadcrumb-item text-muted">Payroll</li>
                <li class="breadcrumb-item active">Show Payroll</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold mb-1">Detail Payroll</h4>
                <p class="text-muted mb-0" style="font-size:13px;">
                    <i class="typcn typcn-calendar mr-1"></i>Period: <strong>{{ $payroll->period }}</strong>
                </p>
            </div>
            <a href="{{ url()->previous() }}"
                class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                style="border-radius:6px; font-size:13px;">
                <i class="typcn typcn-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="row">
            {{-- Left: Info Payroll --}}
            <div class="col-md-5 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        {{-- Avatar + Nama --}}
                        <div class="d-flex align-items-center mb-4 pb-3" style="border-bottom:1px solid #f0f0f0;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width:48px; height:48px; background:#e8e3ff; color:#6c3fdf; font-weight:700; font-size:18px; flex-shrink:0;">
                                {{ strtoupper(substr($payroll->employee->full_name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0 font-weight-bold">{{ $payroll->employee->full_name }}</h6>
                                <small class="text-muted">{{ $payroll->period }}</small>
                            </div>
                            <div class="ml-auto">
                                @if ($payroll->status == 'paid')
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
                            </div>
                        </div>

                        {{-- Salary Info --}}
                        <div class="mb-3 d-flex justify-content-between align-items-center py-2"
                            style="border-bottom:1px dashed #f0f0f0;">
                            <span class="text-muted" style="font-size:13px;">Gaji Pokok</span>
                            <span style="font-size:13px; font-weight:500;">Rp {{ number_format($payroll->salary_basic) }}</span>
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center py-2"
                            style="border-bottom:1px dashed #f0f0f0;">
                            <span class="text-muted" style="font-size:13px;">Total Tunjangan</span>
                            <span style="font-size:13px; font-weight:500; color:#28a745;">
                                + Rp {{ number_format($payroll->total_allowance) }}
                            </span>
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center py-2"
                            style="border-bottom:1px dashed #f0f0f0;">
                            <span class="text-muted" style="font-size:13px;">Total Potongan</span>
                            <span style="font-size:13px; font-weight:500; color:#dc3545;">
                                - Rp {{ number_format($payroll->total_deduction) }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <span class="font-weight-bold" style="font-size:14px;">Gaji Bersih</span>
                            <span class="font-weight-bold" style="font-size:16px; color:#6c3fdf;">
                                Rp {{ number_format($payroll->net_salary) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Payroll Items --}}
            <div class="col-md-7 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 py-3 px-4" style="background:#f8f9fc;">
                        <h6 class="mb-0 font-weight-bold" style="font-size:13px;">Rincian Komponen Gaji</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background:#f8f9fc;">
                                    <tr>
                                        <th class="border-0 px-4 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">No</th>
                                        <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Komponen</th>
                                        <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Deskripsi</th>
                                        <th class="border-0 py-3 text-right text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payroll->items as $item)
                                        <tr>
                                            <td class="px-4 align-middle" style="font-size:13px;">{{ $loop->iteration }}</td>
                                            <td class="align-middle">
                                                <span style="font-size:13px; font-weight:500;">{{ $item->salaryComponent->name }}</span>
                                                <br>
                                                @if ($item->salaryComponent->type == 'allowance')
                                                    <span class="badge badge-pill px-2"
                                                        style="background:#d4edda; color:#155724; font-size:10px;">Tunjangan</span>
                                                @elseif ($item->salaryComponent->type == 'deduction')
                                                    <span class="badge badge-pill px-2"
                                                        style="background:#f8d7da; color:#721c24; font-size:10px;">Potongan</span>
                                                @else
                                                    <span class="badge badge-pill px-2"
                                                        style="background:#cce5ff; color:#004085; font-size:10px;">Lembur</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-muted" style="font-size:12px;">{{ $item->description }}</td>
                                            <td class="align-middle text-right" style="font-size:13px; font-weight:600;">
                                                @if ($item->salaryComponent->type == 'deduction')
                                                    <span class="text-danger">- Rp {{ number_format($item->amount) }}</span>
                                                @else
                                                    <span class="text-success">+ Rp {{ number_format($item->amount) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                Belum ada komponen gaji
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

    </div>
</div>