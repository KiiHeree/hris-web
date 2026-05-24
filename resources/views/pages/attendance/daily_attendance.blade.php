@section('title', 'Daily Attendance')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="background:none; padding:0;">
                <li class="breadcrumb-item text-muted">Attendance</li>
                <li class="breadcrumb-item active">Daily Attendance</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold mb-1">Daily Attendance</h4>
                <p class="text-muted mb-0" style="font-size:13px;">
                    <i class="typcn typcn-calendar mr-1"></i>{{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
        </div>

        {{-- Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#f8f9fc;">
                            <tr>
                                <th class="border-0 px-4 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">No</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Employee</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Check In</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Check Out</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Status</th>
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
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                            <span style="font-size:13px; font-weight:500;">{{ $item->name }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle" style="font-size:13px;">
                                        {{ $item->attendance->first()?->check_in ?? '-' }}
                                    </td>
                                    <td class="align-middle" style="font-size:13px;">
                                        {{ $item->attendance->first()?->check_out ?? '-' }}
                                    </td>
                                    <td class="align-middle">
                                        @php
                                            $s = $item->attendance->first()?->status ?? null;
                                            $badge = match($s) {
                                                'hadir'  => ['bg' => '#d4edda', 'color' => '#155724'],
                                                'telat'  => ['bg' => '#fff3cd', 'color' => '#856404'],
                                                'alpha'  => ['bg' => '#f8d7da', 'color' => '#721c24'],
                                                'izin','sakit','cuti' => ['bg' => '#cce5ff', 'color' => '#004085'],
                                                default  => ['bg' => '#f0f0f0', 'color' => '#6c757d'],
                                            };
                                        @endphp
                                        <span class="badge badge-pill px-3 py-1"
                                            style="background:{{ $badge['bg'] }}; color:{{ $badge['color'] }}; font-size:11px;">
                                            {{ $s ? ucfirst($s) : '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="typcn typcn-document" style="font-size:32px;"></i>
                                        <p class="mt-2 mb-0">Belum ada data absensi hari ini</p>
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