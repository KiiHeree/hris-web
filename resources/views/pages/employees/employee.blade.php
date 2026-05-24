@section('title', 'Employee Directory')
@extends('layouts.app-controller')
@section('content')
<div class="az-content-body pd-lg-l-40 d-flex flex-column">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background:none; padding:0;">
            <li class="breadcrumb-item text-muted">Employee</li>
            <li class="breadcrumb-item active">Employee Directory</li>
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
            <h4 class="font-weight-bold mb-1">Employee Directory</h4>
            <p class="text-muted mb-0" style="font-size:13px;">Kelola daftar karyawan perusahaan</p>
        </div>
        <a href="{{ route('employee.employee.create') }}"
            class="btn btn-primary d-flex align-items-center"
            style="border-radius:8px; font-size:13px; padding:8px 16px;">
            <i class="typcn typcn-plus mr-1"></i> Create
        </a>
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
                            <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Department</th>
                            <th class="border-0 py-3 text-uppercase" style="font-size:11px; color:#6c757d; letter-spacing:.5px;">Position</th>
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
                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                        </div>
                                        <span style="font-size:13px; font-weight:500;">{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td class="align-middle" style="font-size:13px;">{{ $item->employee->department->name ?? '-' }}</td>
                                <td class="align-middle" style="font-size:13px;">{{ $item->employee->position->name ?? '-' }}</td>
                                <td class="align-middle">
                                    <div class="d-flex" style="gap:6px;">
                                        <a href="{{ route('employee.employee.edit', $item->id) }}"
                                            class="btn btn-sm btn-warning d-flex align-items-center"
                                            style="border-radius:6px; font-size:12px; padding:4px 10px;">
                                            <i class="typcn typcn-edit mr-1"></i> Edit
                                        </a>
                                        <a href="{{ route('employee.employee.show', $item->id) }}"
                                            class="btn btn-sm btn-primary d-flex align-items-center"
                                            style="border-radius:6px; font-size:12px; padding:4px 10px;">
                                            <i class="typcn typcn-eye mr-1"></i> Detail
                                        </a>
                                        <form action="{{ route('employee.employee.destroy', $item->id) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus karyawan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-danger d-flex align-items-center"
                                                style="border-radius:6px; font-size:12px; padding:4px 10px;">
                                                <i class="typcn typcn-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="typcn typcn-group" style="font-size:32px;"></i>
                                    <p class="mt-2 mb-0">Belum ada data karyawan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection