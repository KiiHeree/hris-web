@section('title', 'Role')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="background:none; padding:0;">
                <li class="breadcrumb-item text-muted">Settings</li>
                <li class="breadcrumb-item active">Role</li>
            </ol>
        </nav>

        @if (Session::has('success'))
            <div id="successModal"
                style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(148,163,184,0.4); backdrop-filter:blur(8px); z-index:9999; display:flex; justify-content:center; align-items:center;">
                <div
                    style="background:white; border-radius:20px; padding:40px 32px; width:100%; max-width:420px; text-align:center; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.1);">
                    <button onclick="document.getElementById('successModal').style.display='none'"
                        style="position:absolute; top:16px; right:16px; width:32px; height:32px; border-radius:50%; border:none; background:#f1f5f9; color:#94a3b8; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                        ×
                    </button>
                    <div
                        style="width:64px; height:64px; background:#f0fdf4; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#22c55e"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <h5 style="font-weight:700; font-size:20px; color:#0f172a; margin-bottom:10px;">Well Done!</h5>
                    <p style="color:#64748b; font-size:14px; line-height:1.6; margin-bottom:24px;">
                        {{ Session::get('success') }}</p>
                    <button onclick="document.getElementById('successModal').style.display='none'"
                        style="background:#22c55e; color:white; border:none; border-radius:10px; padding:12px 32px; font-size:14px; font-weight:600; cursor:pointer; width:100%;">
                        Okay, Got It
                    </button>
                </div>
            </div>
        @endif
        
        @if (Session::has('error'))
            <div id="errorModal"
                style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(148,163,184,0.4); backdrop-filter:blur(8px); z-index:9999; display:flex; justify-content:center; align-items:center;">
                <div
                    style="background:white; border-radius:20px; padding:40px 32px; width:100%; max-width:420px; text-align:center; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.1);">
                    <button onclick="document.getElementById('errorModal').style.display='none'"
                        style="position:absolute; top:16px; right:16px; width:32px; height:32px; border-radius:50%; border:none; background:#f1f5f9; color:#94a3b8; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                        ×
                    </button>
                    <div
                        style="width:64px; height:64px; background:#fef2f2; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ef4444"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                    <h5 style="font-weight:700; font-size:20px; color:#0f172a; margin-bottom:10px;">Oops!</h5>
                    <p style="color:#64748b; font-size:14px; line-height:1.6; margin-bottom:24px;">
                        {{ Session::get('error') }}</p>
                    <button onclick="document.getElementById('errorModal').style.display='none'"
                        style="background:#ef4444; color:white; border:none; border-radius:10px; padding:12px 32px; font-size:14px; font-weight:600; cursor:pointer; width:100%;">
                        Okay, Got It
                    </button>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold mb-1">Role</h4>
                <p class="text-muted mb-0" style="font-size:13px;">Kelola daftar role dalam sistem</p>
            </div>
            <button class="btn btn-primary d-flex align-items-center"
                style="border-radius:8px; font-size:13px; padding:8px 16px;" wire:click="showModal('create')">
                <i class="typcn typcn-plus mr-1"></i> Create
            </button>
        </div>

        {{-- Table --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#f8f9fc;">
                            <tr>
                                <th class="border-0 px-4 py-3 text-uppercase"
                                    style="font-size:11px; color:#6c757d; letter-spacing:.5px;">No</th>
                                <th class="border-0 py-3 text-uppercase"
                                    style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Name</th>
                                <th class="border-0 py-3 text-uppercase"
                                    style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Permission</th>
                                <th class="border-0 py-3 text-uppercase"
                                    style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="px-4 align-middle" style="font-size:13px;">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <span class="font-weight-bold"
                                            style="font-size:13px;">{{ $item->name }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap" style="gap:4px;">
                                            @forelse ($item->permissions as $p)
                                                <span class="badge badge-pill px-2 py-1"
                                                    style="background:#e8e3ff; color:#6c3fdf; font-size:11px;">
                                                    {{ $p->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted" style="font-size:12px;">Tidak ada
                                                    permission</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex" style="gap:6px;">
                                            <button class="btn btn-sm btn-warning d-flex align-items-center"
                                                style="border-radius:6px; font-size:12px; padding:4px 10px;"
                                                wire:click="showModal('update', {{ $item->id }})">
                                                <i class="typcn typcn-edit mr-1"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger d-flex align-items-center"
                                                style="border-radius:6px; font-size:12px; padding:4px 10px;"
                                                wire:click="delete({{ $item->id }})">
                                                <i class="typcn typcn-trash mr-1"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="typcn typcn-document" style="font-size:32px;"></i>
                                        <p class="mt-2 mb-0">Belum ada data role</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <div class="modal fade {{ $show_modal ? 'show' : '' }}" id="roleModal" tabindex="-1" role="dialog"
        style="display: {{ $show_modal ? 'block' : 'none' }};">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:12px; border:none;">
                <div class="modal-header" style="border-bottom:1px solid #f0f0f0;">
                    <h5 class="modal-title font-weight-bold text-capitalize">{{ $mode }} Role</h5>
                    <button type="button" class="close" wire:click="closeModal">
                        <span>&times;</span>
                    </button>
                </div>
                @if ($mode == 'create')
                    <form wire:submit.prevent="store">
                    @elseif ($mode == 'update')
                        <form wire:submit.prevent="update">
                @endif
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label style="font-size:13px; font-weight:500;">Name</label>
                        <input class="form-control" placeholder="Input role name" wire:model="name" type="text"
                            required style="border-radius:8px; font-size:13px;">
                    </div>
                    <div class="form-group mb-0">
                        <label style="font-size:13px; font-weight:500;">Permission</label>
                        <div class="row mt-2">
                            @foreach ($permissions as $p)
                                <div class="col-6 mb-2" wire:key="permission-{{ $loop->iteration }}">
                                    <label class="d-flex align-items-center"
                                        style="font-size:13px; cursor:pointer; gap:8px;">
                                        <input type="checkbox" wire:model="selected_permissions"
                                            value="{{ $p->name }}">
                                        <span>{{ $p->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f0f0f0;">
                    <button type="button" class="btn btn-outline-secondary"
                        style="border-radius:8px; font-size:13px;" wire:click="closeModal">Batal</button>
                    <button type="submit" class="btn btn-primary"
                        style="border-radius:8px; font-size:13px;">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
