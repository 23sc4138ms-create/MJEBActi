@extends('format.layout')

@section('Content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>User Report</h2>
                <div>
                    <a href="{{ route('admin.reports.user.pdf') }}" class="btn btn-danger btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.reports.user.excel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
            </div>

            <table class="table table-striped">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username ?? '-' }}</td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td>{{ ucfirst((string) ($user->role ?? '-')) }}</td>
                        <td>{{ (int) ($user->is_active ?? 0) === 1 ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No user account data found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
