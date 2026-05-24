@section('title', 'Dashboard')
<div>
    {{-- Alert --}}
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" id="alertBox"
            style="position:fixed; top:80px; right:16px; z-index:9998; min-width:280px;" role="alert">
            <i class="typcn typcn-tick mr-2"></i>{{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" id="alertBox"
            style="position:fixed; top:80px; right:16px; z-index:9998; min-width:280px;" role="alert">
            <i class="typcn typcn-times mr-2"></i>{{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (Auth::user()->hasRole('employee'))
        {{-- ===== EMPLOYEE DASHBOARD ===== --}}

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold mb-1">Hi, {{ Auth::user()->employee->full_name }}!</h4>
                <p class="text-muted mb-0" style="font-size:13px;">
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
            <button id="btn-absen" class="btn btn-purple d-flex align-items-center"
                style="border-radius:8px; padding:8px 20px;"
                {{ $status == 'done' || $status == 'libur' ? 'disabled' : '' }}
                onclick="openFaceModal('{{ Auth::user()->employee->id }}', '{{ $status }}')">
                @if ($status == 'done')
                    <i class="typcn typcn-tick mr-2"></i> Selesai
                @elseif ($status == 'not_checked_in')
                    <i class="typcn typcn-time mr-2"></i> Check In
                @elseif ($status == 'checked_in')
                    <i class="typcn typcn-power mr-2"></i> Check Out
                @elseif ($status == 'libur')
                    <i class="typcn typcn-home mr-2"></i> Libur
                @endif
            </button>
        </div>

        {{-- Jadwal & Kehadiran Hari Ini --}}
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-2"
                            style="font-size:11px; text-transform:uppercase; letter-spacing:.5px;">Jadwal Hari Ini</p>
                        @if ($workSchedule && $workSchedule->is_working_day)
                            <div class="d-flex align-items-center mt-1">
                                <div class="mr-4">
                                    <small class="text-muted d-block">Masuk</small>
                                    <h5 class="font-weight-bold mb-0" style="color:#6c3fdf;">
                                        {{ \Carbon\Carbon::parse($workSchedule->start_time)->format('H:i') }}
                                    </h5>
                                </div>
                                <div class="text-muted mx-2" style="font-size:18px;">→</div>
                                <div>
                                    <small class="text-muted d-block">Pulang</small>
                                    <h5 class="font-weight-bold mb-0" style="color:#6c3fdf;">
                                        {{ \Carbon\Carbon::parse($workSchedule->end_time)->format('H:i') }}
                                    </h5>
                                </div>
                            </div>
                        @else
                            <h5 class="font-weight-bold mt-2 text-muted">Hari Libur 🎉</h5>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-2"
                            style="font-size:11px; text-transform:uppercase; letter-spacing:.5px;">Kehadiran Hari Ini
                        </p>
                        @if ($todayAttendance)
                            <div class="d-flex align-items-center mt-1">
                                <div class="mr-4">
                                    <small class="text-muted d-block">Check In</small>
                                    <h5 class="font-weight-bold mb-0 text-success">
                                        {{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') : '-' }}
                                    </h5>
                                </div>
                                <div class="text-muted mx-2" style="font-size:18px;">→</div>
                                <div>
                                    <small class="text-muted d-block">Check Out</small>
                                    <h5 class="font-weight-bold mb-0 text-danger">
                                        {{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') : '-' }}
                                    </h5>
                                </div>
                                <div class="ml-auto">
                                    @php
                                        $statusColor = match ($todayAttendance->status) {
                                            'hadir' => ['bg' => '#d4edda', 'color' => '#155724'],
                                            'telat' => ['bg' => '#fff3cd', 'color' => '#856404'],
                                            'alpha' => ['bg' => '#f8d7da', 'color' => '#721c24'],
                                            default => ['bg' => '#cce5ff', 'color' => '#004085'],
                                        };
                                    @endphp
                                    <span class="badge badge-pill px-3 py-1"
                                        style="background:{{ $statusColor['bg'] }}; color:{{ $statusColor['color'] }}; font-size:11px;">
                                        {{ ucfirst($todayAttendance->status) }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mt-2 mb-0" style="font-size:13px;">Belum absen hari ini</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Bulan Ini --}}
        <div class="row mb-4">
            @php
                $statCards = [
                    [
                        'label' => 'Hadir',
                        'value' => $stats['hadir'],
                        'icon' => 'typcn-user',
                        'bg' => '#d4edda',
                        'color' => '#155724',
                    ],
                    [
                        'label' => 'Izin/Sakit',
                        'value' => $stats['izin'],
                        'icon' => 'typcn-document-text',
                        'bg' => '#cce5ff',
                        'color' => '#004085',
                    ],
                    [
                        'label' => 'Alpha',
                        'value' => $stats['alpha'],
                        'icon' => 'typcn-times',
                        'bg' => '#f8d7da',
                        'color' => '#721c24',
                    ],
                    [
                        'label' => 'Telat',
                        'value' => $stats['telat'],
                        'icon' => 'typcn-time',
                        'bg' => '#fff3cd',
                        'color' => '#856404',
                    ],
                ];
            @endphp
            @foreach ($statCards as $card)
                <div class="col-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width:42px; height:42px; background:{{ $card['bg'] }}; flex-shrink:0;">
                                <i class="typcn {{ $card['icon'] }}"
                                    style="color:{{ $card['color'] }}; font-size:20px;"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0"
                                    style="font-size:11px; text-transform:uppercase; letter-spacing:.5px;">
                                    {{ $card['label'] }}</p>
                                <h4 class="font-weight-bold mb-0">{{ $card['value'] }}</h4>
                                <small class="text-muted">Bulan ini</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Payroll Terakhir --}}
        @if ($latestPayroll)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <p class="text-muted mb-3" style="font-size:11px; text-transform:uppercase; letter-spacing:.5px;">
                        Payroll Terakhir — {{ $latestPayroll->period }}
                    </p>
                    <div class="row">
                        <div class="col-6 col-md-3 mb-2">
                            <small class="text-muted d-block">Gaji Pokok</small>
                            <span class="font-weight-bold">Rp {{ number_format($latestPayroll->salary_basic) }}</span>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <small class="text-muted d-block">Tunjangan</small>
                            <span class="font-weight-bold text-success">+ Rp
                                {{ number_format($latestPayroll->total_allowance) }}</span>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <small class="text-muted d-block">Potongan</small>
                            <span class="font-weight-bold text-danger">- Rp
                                {{ number_format($latestPayroll->total_deduction) }}</span>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <small class="text-muted d-block">Gaji Bersih</small>
                            <span class="font-weight-bold" style="color:#6c3fdf; font-size:15px;">
                                Rp {{ number_format($latestPayroll->net_salary) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        {{-- ===== ADMIN/MANAJER DASHBOARD ===== --}}

        {{-- Header --}}
        <div class="mb-4">
            <h4 class="font-weight-bold mb-1">Hi, {{ Auth::user()->employee->full_name }}!</h4>
            <p class="text-muted mb-0" style="font-size:13px;">
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-4">
            @php
                $adminCards = [
                    [
                        'label' => 'Total Karyawan',
                        'value' => $adminStats['total_karyawan'],
                        'icon' => 'typcn-group',
                        'bg' => '#e8e3ff',
                        'color' => '#6c3fdf',
                    ],
                    [
                        'label' => 'Hadir Hari Ini',
                        'value' => $adminStats['hadir'],
                        'icon' => 'typcn-user',
                        'bg' => '#d4edda',
                        'color' => '#155724',
                    ],
                    [
                        'label' => 'Izin/Sakit',
                        'value' => $adminStats['izin'],
                        'icon' => 'typcn-document-text',
                        'bg' => '#cce5ff',
                        'color' => '#004085',
                    ],
                    [
                        'label' => 'Alpha',
                        'value' => $adminStats['alpha'],
                        'icon' => 'typcn-times',
                        'bg' => '#f8d7da',
                        'color' => '#721c24',
                    ],
                ];
            @endphp
            @foreach ($adminCards as $card)
                <div class="col-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width:42px; height:42px; background:{{ $card['bg'] }}; flex-shrink:0;">
                                <i class="typcn {{ $card['icon'] }}"
                                    style="color:{{ $card['color'] }}; font-size:20px;"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0"
                                    style="font-size:11px; text-transform:uppercase; letter-spacing:.5px;">
                                    {{ $card['label'] }}</p>
                                <h4 class="font-weight-bold mb-0">{{ $card['value'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Payroll & Belum Absen --}}
        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-3"
                            style="font-size:11px; text-transform:uppercase; letter-spacing:.5px;">
                            Payroll — {{ \Carbon\Carbon::now()->format('M Y') }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3"
                            style="border-bottom:1px dashed #f0f0f0;">
                            <span class="text-muted" style="font-size:13px;">Total Payroll</span>
                            <span class="font-weight-bold">{{ $payrollStats['total'] }} karyawan</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3"
                            style="border-bottom:1px dashed #f0f0f0;">
                            <span class="text-muted" style="font-size:13px;">Draft</span>
                            <span class="badge badge-pill px-3 py-1"
                                style="background:#fff3cd; color:#856404; font-size:12px;">
                                {{ $payrollStats['draft'] }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3"
                            style="border-bottom:1px dashed #f0f0f0;">
                            <span class="text-muted" style="font-size:13px;">Paid</span>
                            <span class="badge badge-pill px-3 py-1"
                                style="background:#d4edda; color:#155724; font-size:12px;">
                                {{ $payrollStats['paid'] }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold" style="font-size:13px;">Total Dibayar</span>
                            <span class="font-weight-bold" style="color:#6c3fdf; font-size:15px;">
                                Rp {{ number_format($payrollStats['amount']) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header border-0 py-3 px-4" style="background:#f8f9fc;">
                        <h6 class="mb-0 font-weight-bold" style="font-size:13px;">Belum Absen Hari Ini</h6>
                    </div>
                    <div class="card-body p-0">
                        @forelse ($notAttended as $emp)
                            <div class="d-flex align-items-center px-4 py-3" style="border-bottom:1px solid #f8f9fc;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mr-3"
                                    style="width:36px; height:36px; background:#e8e3ff; color:#6c3fdf; font-weight:600; font-size:13px; flex-shrink:0;">
                                    {{ strtoupper(substr($emp->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="mb-0 font-weight-500" style="font-size:13px;">{{ $emp->full_name }}</p>
                                    <small class="text-muted">{{ $emp->position->name ?? '-' }}</small>
                                </div>
                                <span class="ml-auto badge badge-pill px-2 py-1"
                                    style="background:#f8d7da; color:#721c24; font-size:11px;">Belum Absen</span>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="typcn typcn-tick" style="font-size:28px; color:#28a745;"></i>
                                <p class="mt-1 mb-0" style="font-size:13px;">Semua karyawan sudah absen! 🎉</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    @endif

    {{-- Face Modal --}}
    <div id="faceModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999; justify-content:center; align-items:center;">
        <div
            style="background:white; padding:24px; border-radius:16px; text-align:center; width:420px; position:relative;">
            <h5 class="font-weight-bold mb-3">Verifikasi Wajah</h5>
            <div
                style="position:relative; width:100%; height:300px; background:#000; border-radius:12px; overflow:hidden;">
                <video id="webcam" autoplay playsinline
                    style="width:100%; height:100%; object-fit:cover; transform:scaleX(-1);"></video>
                <div id="scanner-line"
                    style="position:absolute; top:0; left:0; width:100%; height:2px; background:cyan; box-shadow:0 0 10px cyan; animation:scan 2s infinite;">
                </div>
            </div>
            <div id="face-status" class="mt-3 font-weight-bold text-muted">Mencari wajah...</div>
            <button class="btn btn-outline-secondary mt-3 w-100" style="border-radius:8px;"
                onclick="closeFaceModal()">Batal</button>
        </div>
    </div>

    <style>
        @keyframes scan {
            0% {
                top: 0;
            }

            50% {
                top: 100%;
            }

            100% {
                top: 0;
            }
        }
    </style>
</div>

@section('script')
    <script>
        let videoStream = null;
        let isProcessing = false;
        let scanInterval = null;

        // Auto-hide Alert
        setTimeout(() => {
            const alert = document.getElementById('alertBox');
            if (alert) alert.style.display = 'none';
        }, 4000);

        async function openFaceModal(targetId, currentStatus) {
            const modal = document.getElementById('faceModal');
            const video = document.getElementById('webcam');
            const statusText = document.getElementById('face-status');

            modal.style.display = 'flex';
            isProcessing = true;
            statusText.innerHTML = '<span class="text-muted">Mengaktifkan Kamera...</span>';

            try {
                videoStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: 640,
                        height: 480,
                        facingMode: "user"
                    }
                });
                video.srcObject = videoStream;

                statusText.innerHTML = '<div class="spinner-grow spinner-grow-sm text-purple"></div> Scanning...';

                scanInterval = setInterval(async () => {
                    if (!isProcessing) return;

                    const canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0);

                    canvas.toBlob(async (blob) => {
                        const formData = new FormData();
                        formData.append('file', blob, 'face.jpg');

                        // 🔥 TAMBAHIN BARIS INI: Kirim ID user yang login ke Python
                        formData.append('logged_in_id', targetId);

                        try {
                            const response = await fetch(
                                'http://127.0.0.1:8001/api/recognize', {
                                    method: 'POST',
                                    body: formData
                                });

                            if (!response.ok) throw new Error("Server Error");

                            const data = await response.json();

                            // LOGIKA DI SINI JUGA JADI LEBIH SIMPEL
                            if (data.success) {
                                // WAJAH COCOK + DATA MASUK DB
                                statusText.innerHTML =
                                    `<span class="text-success"><i class="fas fa-check-circle"></i> ${data.message}</span>`;
                                isProcessing = false;
                                clearInterval(scanInterval);

                                @this.call('$refresh'); // Refresh status tombol
                                setTimeout(closeFaceModal, 1500);
                            } else {
                                // KALAU MUKA GAK COCOK / BUKAN AKUNNYA
                                statusText.innerHTML =
                                    `<span class="text-danger">${data.message}</span>`;
                            }
                        } catch (e) {
                            console.error("Detail Error:", e);
                            statusText.innerHTML =
                                '<span class="text-warning">Gagal terhubung ke AI Service</span>';
                        }
                    }, 'image/jpeg', 0.7);

                }, 2000);

            } catch (err) {
                alert("Kamera tidak bisa diakses. Pastikan izin kamera diberikan.");
                closeFaceModal();
            }
        }

        function closeFaceModal() {
            isProcessing = false;

            // 1. Hentikan interval scanning
            if (scanInterval) {
                clearInterval(scanInterval);
                scanInterval = null;
            }

            // 2. MATIIN HARDWARE KAMERA (Lampu Kamera)
            if (videoStream) {
                const tracks = videoStream.getTracks();
                tracks.forEach(track => {
                    track.stop(); // Ini yang bikin lampu kamera mati
                    console.log("Track stopped:", track.kind);
                });
                videoStream = null;
            }

            // 3. Sembunyikan Modal
            document.getElementById('faceModal').style.display = 'none';

            // 4. Bersihkan srcObject video agar memori lega
            const video = document.getElementById('webcam');
            if (video) {
                video.srcObject = null;
            }
        }
    </script>
@endsection
