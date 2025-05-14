@extends('admin.layouts.base')
@section('title', 'Dashboard')
@section('content')

{{-- Pesan sukses setelah hapus --}}
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<!-- Tabel List Device -->
<div class="card shadow mb-4 mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Device ID</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Tipe Project</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($devices as $device)
                    <tr>
                        <td>{{ $device->device_id }}</td>
                        <td>{{ $device->created_at->format('Y-m-d') }}</td>
                        <td>
                            <span class="text-danger">{{ $device->status ?? 'Offline' }}</span>
                        </td>
                        <td>{{ $device->tipe }}</td>
                        <td>
                            <a href="{{ route('project.detail', ['id' => $device->id]) }}"
                                class="btn btn-success btn-sm" style="margin-right: 10px">
                                Detail
                            </a>
                            <form action="{{ route('project.delete', ['id' => $device->id]) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Yakin ingin menghapus project ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada project.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection