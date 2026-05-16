@section('title', 'Dashboard')
<div>
    <div class="az-dashboard-one-title">
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
        <div>
            <h2 class="az-dashboard-title">Hi, welcome back!</h2>
            <p class="az-dashboard-text">Your web analytics dashboard template.</p>
        </div>
        <div class="az-content-header-right">
            <button id="btn-absen" class="btn btn-purple" type="button" 
                {{ $status == 'done' || $status == 'libur' ? 'disabled' : '' }}
                onclick="openFaceModal('{{ Auth::user()->employee->id }}', '{{ $status }}')">

                @if ($status == 'done') Done
                @elseif ($status == 'not_checked_in') Check In
                @elseif ($status == 'checked_in') Check Out
                @elseif ($status == 'libur') Libur
                @endif
            </button>
        </div>
    </div>
    <div class="az-dashboard-nav">
        <nav class="nav">
            <a class="nav-link active" data-toggle="tab" href="#">Overview</a>
            <a class="nav-link" data-toggle="tab" href="#">Audiences</a>
            <a class="nav-link" data-toggle="tab" href="#">Demographics</a>
            <a class="nav-link" data-toggle="tab" href="#">More</a>
        </nav>

        <nav class="nav">
            <a class="nav-link" href="#"><i class="far fa-save"></i> Save Report</a>
            <a class="nav-link" href="#"><i class="far fa-file-pdf"></i> Export to PDF</a>
            <a class="nav-link" href="#"><i class="far fa-envelope"></i>Send to Email</a>
            <a class="nav-link" href="#"><i class="fas fa-ellipsis-h"></i></a>
        </nav>
    </div>

    <div class="row row-sm mg-b-20">
        <div class="col-lg-7 ht-lg-100p">
            <div class="card card-dashboard-one">
                <div class="card-header">
                    <div>
                        <h6 class="card-title">Website Audience Metrics</h6>
                        <p class="card-text">Audience to which the users belonged while on the current date range.</p>
                    </div>
                    <div class="btn-group">
                        <button class="btn active">Day</button>
                        <button class="btn">Week</button>
                        <button class="btn">Month</button>
                    </div>
                </div><!-- card-header -->
                <div class="card-body">
                    <div class="card-body-top">
                        <div>
                            <label class="mg-b-0">Users</label>
                            <h2>13,956</h2>
                        </div>
                        <div>
                            <label class="mg-b-0">Bounce Rate</label>
                            <h2>33.50%</h2>
                        </div>
                        <div>
                            <label class="mg-b-0">Page Views</label>
                            <h2>83,123</h2>
                        </div>
                        <div>
                            <label class="mg-b-0">Sessions</label>
                            <h2>16,869</h2>
                        </div>
                    </div><!-- card-body-top -->
                    <div class="flot-chart-wrapper">
                        <div id="flotChart" class="flot-chart"></div>
                    </div><!-- flot-chart-wrapper -->
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
        <div class="col-lg-5 mg-t-20 mg-lg-t-0">
            <div class="row row-sm">
                <div class="col-sm-6">
                    <div class="card card-dashboard-two">
                        <div class="card-header">
                            <h6>33.50% <i class="icon ion-md-trending-up tx-success"></i> <small>18.02%</small></h6>
                            <p>Bounce Rate</p>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="chart-wrapper">
                                <div id="flotChart1" class="flot-chart"></div>
                            </div><!-- chart-wrapper -->
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                    <div class="card card-dashboard-two">
                        <div class="card-header">
                            <h6>86k <i class="icon ion-md-trending-down tx-danger"></i> <small>0.86%</small></h6>
                            <p>Total Users</p>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="chart-wrapper">
                                <div id="flotChart2" class="flot-chart"></div>
                            </div><!-- chart-wrapper -->
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-12 mg-t-20">
                    <div class="card card-dashboard-three">
                        <div class="card-header">
                            <p>All Sessions</p>
                            <h6>16,869 <small class="tx-success"><i class="icon ion-md-arrow-up"></i> 2.87%</small></h6>
                            <small>The total number of sessions within the date range. It is the period time a user is
                                actively engaged with your website, page or app, etc.</small>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="chart"><canvas id="chartBar5"></canvas></div>
                        </div>
                    </div>
                </div>
            </div><!-- row -->
        </div><!--col -->
    </div><!-- row -->

    <div id="faceModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:15px; text-align:center; width:400px; position:relative;">
            <h4 class="mb-3">Verifikasi Wajah</h4>
            
            <div style="position:relative; width:100%; height:300px; background:#000; border-radius:10px; overflow:hidden;">
                <video id="webcam" autoplay playsinline style="width:100%; height:100%; object-fit:cover; transform: scaleX(-1);"></video>
                <div id="scanner-line" style="position:absolute; top:0; left:0; width:100%; height:2px; background:cyan; box-shadow:0 0 10px cyan; animation: scan 2s infinite;"></div>
            </div>

            <div id="face-status" class="mt-3 fw-bold text-muted">Mencari wajah...</div>
            
            <button class="btn btn-secondary mt-3 w-100" onclick="closeFaceModal()">Batal</button>
        </div>
    </div>

    <style>
        @keyframes scan {
            0% { top: 0; }
            50% { top: 100%; }
            100% { top: 0; }
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
            if(alert) alert.style.display = 'none';
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
                    video: { width: 640, height: 480, facingMode: "user" } 
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

                        try {
                            const response = await fetch('http://127.0.0.1:8001/api/recognize', {
                                method: 'POST',
                                body: formData
                            });
                            
                            if (!response.ok) throw new Error("Server Error");
                            
                            const data = await response.json();

                            if (data.employee_id == targetId) {
                                
                                if (data.success) {
                                    // WAJAH COCOK + DATA MASUK DB
                                    statusText.innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> ${data.message}</span>`;
                                    isProcessing = false;
                                    clearInterval(scanInterval);
                                    
                                    @this.call('$refresh'); // Refresh status tombol
                                    setTimeout(closeFaceModal, 1500);
                                } else {
                                    statusText.innerHTML = `<span class="text-warning"><i class="fas fa-exclamation-triangle"></i> ${data.message}</span>`;
                                }
                                @this.call('$refresh');

                                setTimeout(closeFaceModal, 1500);
                            } else {
                                statusText.innerHTML = `<span class="text-danger">${data.message || 'Wajah tidak dikenal'}</span>`;
                            }
                        } catch (e) {
                            console.error("Detail Error:", e);
                            statusText.innerHTML = '<span class="text-warning">Gagal terhubung ke AI Service</span>';
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