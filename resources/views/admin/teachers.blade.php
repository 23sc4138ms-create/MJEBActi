@extends('format.layout')

@section('title', 'Teacher Accounts')

@section('Content')
    <style>
        .teachers-shell {
            max-width: 1180px;
            margin: 0 auto;
        }
        .teachers-hero {
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            background: linear-gradient(135deg, #0ea5ff 0%, #0369a1 100%);
            color: #fff;
            padding: 1.4rem 1.5rem;
            box-shadow: 0 18px 40px rgba(14,165,255,0.16);
            margin-bottom: 1.2rem;
        }
        .teachers-hero::after {
            content: '';
            position: absolute;
            inset: auto -40px -70px auto;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .teachers-hero h1 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.9rem;
            font-weight: 800;
            color: #fff;
        }
        .teachers-hero p {
            margin: 0.35rem 0 0;
            color: rgba(255,255,255,0.88);
            font-size: 0.96rem;
        }
        .teachers-card {
            background: #fff;
            border: 1px solid #d9efff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(3,105,161,0.08);
        }
        .teachers-card-head {
            padding: 1.2rem 1.4rem;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }
        .teachers-card-head h2 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: #fff;
        }
        .teachers-card-head p {
            margin: 0.3rem 0 0;
            font-size: 0.92rem;
            color: rgba(255,255,255,0.9);
        }
        .teachers-actions {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
        }
        .btn-sky,
        .btn-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.72rem 1rem;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            border: 0;
        }
        .btn-sky {
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
        }
        .btn-soft {
            background: #f8fcff;
            color: #0369a1;
            border: 1px solid #cdeeff;
        }
        .alert-soft {
            border-radius: 10px;
            padding: 0.85rem 1rem;
            margin: 1.2rem 1.4rem 0;
        }
        .alert-soft.success { background: #eff8ff; border: 1px solid #93c5fd; color: #0369a1; }
        .teachers-table-wrap { padding: 1.4rem; }
        .teachers-table {
            width: 100%;
            border-collapse: collapse;
        }
        .teachers-table thead th {
            text-align: left;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #7aaed3;
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #e5eef6;
        }
        .teachers-table tbody td {
            padding: 0.95rem 0.75rem;
            border-bottom: 1px solid #edf5fb;
            color: #0f172a;
            font-weight: 600;
        }
        .badge-soft {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            background: #eff8ff;
            color: #0369a1;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
        }
        .badge-muted {
            background: #f1f5f9;
            color: #64748b;
        }
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: #64748b;
        }
        .empty-state i {
            font-size: 2rem;
            color: #0ea5ff;
            margin-bottom: 0.75rem;
            display: block;
        }
        @media (max-width: 768px) {
            .teachers-table-wrap { overflow-x: auto; }
            .teachers-table { min-width: 760px; }
        }
    </style>

    <div class="teachers-shell">
        <div class="teachers-hero">
            <h1>Teacher Accounts</h1>
            <p>View every inserted teacher account in one place.</p>
        </div>

        <div class="teachers-card">
            <div class="teachers-card-head">
                <div>
                    <h2><i class="fas fa-chalkboard-user me-2"></i>Teacher List</h2>
                    <p>All teacher records are shown below.</p>
                </div>
                <div class="teachers-actions">
                    <a href="{{ route('admin.add.teacher') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-sky">Insert Teacher</a>
                    <a href="{{ route('admin.dashboard') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-soft">Back to dashboard</a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert-soft success">{{ session('success') }}</div>
            @endif

            <div class="teachers-table-wrap">
                <table class="teachers-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Teacher Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->id }}</td>
                                <td>{{ $teacher->name ?? $teacher->username ?? '-' }}</td>
                                <td>{{ $teacher->username ?? '-' }}</td>
                                <td>{{ $teacher->email ?? '-' }}</td>
                                <td><span class="badge-soft">{{ ucfirst((string) $teacher->role) }}</span></td>
                                <td>
                                    <span class="badge-soft {{ (int) ($teacher->is_active ?? 0) === 1 ? '' : 'badge-muted' }}">
                                        {{ (int) ($teacher->is_active ?? 0) === 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $teacher->created_at ? $teacher->created_at->format('M d, Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-user-plus"></i>
                                        <div>No teacher accounts found yet.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
