@section('title', 'Permission')
<div>
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="background:none; padding:0;">
                <li class="breadcrumb-item text-muted">Settings</li>
                <li class="breadcrumb-item active">Permission</li>
            </ol>
        </nav>

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

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold mb-1">Permission</h4>
                <p class="text-muted mb-0" style="font-size:13px;">Kelola daftar permission dalam sistem</p>
            </div>
            <button class="btn btn-primary d-flex align-items-center"
                style="border-radius:8px; font-size:13px; padding:8px 16px;"
                wire:click="showModal('create')">
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
                                <th class="border-0 px-4 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">No</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Name</th>
                                <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="px-4 align-middle" style="font-size:13px;">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <span class="badge badge-pill px-3 py-1"
                                            style="background:#e8e3ff; color:#6c3fdf; font-size:12px;">
                                            {{ $item->name }}
                                        </span>
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
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="typcn typcn-document" style="font-size:32px;"></i>
                                        <p class="mt-2 mb-0">Belum ada data permission</p>
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
    <div class="modal fade {{ $show_modal ? 'show' : '' }}" id="permissionModal" tabindex="-1" role="dialog"
        style="display: {{ $show_modal ? 'block' : 'none' }};">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:12px; border:none;">
                <div class="modal-header" style="border-bottom:1px solid #f0f0f0;">
                    <h5 class="modal-title font-weight-bold text-capitalize">{{ $mode }} Permission</h5>
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
                        <input class="form-control" placeholder="Input permission name"
                            wire:model="name" type="text" required
                            style="border-radius:8px; font-size:13px;">
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f0f0f0;">
                    <button type="button" class="btn btn-outline-secondary"
                        style="border-radius:8px; font-size:13px;"
                        wire:click="closeModal">Batal</button>
                    <button type="submit" class="btn btn-primary"
                        style="border-radius:8px; font-size:13px;">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>