@extends('format.layout')

@section('title', 'Degrees - Degree Management')

@section('Content')
    <style>
        .degrees-shell {
            max-width: 1160px;
            margin: 0 auto;
        }
        .degrees-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        .degrees-top h1 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0b2540;
        }
        .btn-sky {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.7rem 1rem;
            border: 0;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
        }
        .degree-card {
            background: #fff;
            border: 1px solid #d9efff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 34px rgba(14,165,255,0.08);
        }
        .degree-table {
            width: 100%;
            border-collapse: collapse;
        }
        .degree-table thead th {
            padding: 0.8rem 1rem;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #fff;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
        }
        .degree-table tbody td {
            padding: 0.95rem 1rem;
            border-bottom: 1px solid #eef6fb;
            vertical-align: middle;
        }
        .degree-table tbody tr:hover td { background: #f8fcff; }
        .degree-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            height: 26px;
            padding: 0 0.55rem;
            border-radius: 999px;
            background: #e0f7ff;
            color: #0369a1;
            font-weight: 800;
            font-size: 0.78rem;
        }
        .action-btns {
            display: flex;
            gap: 0.35rem;
            flex-wrap: wrap;
        }
        .action-btns a,
        .action-btns button {
            border: 0;
            border-radius: 8px;
            padding: 0.55rem 0.7rem;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            color: #fff;
            cursor: pointer;
        }
        .btn-view { background: #0ea5ff; }
        .btn-edit { background: #f59e0b; }
        .btn-delete { background: #ef4444; }
        .alert-soft {
            border-radius: 10px;
            padding: 0.85rem 1rem;
            margin-bottom: 1rem;
        }
        .alert-soft.success { background: #eff8ff; border: 1px solid #93c5fd; color: #0369a1; }
        .alert-soft.error { background: #fff5f5; border: 1px solid #fecaca; color: #b91c1c; }
        .empty-state {
            padding: 2rem 1rem;
            text-align: center;
            color: #94a3b8;
        }
        .pagination-wrap {
            padding: 1rem;
        }
    </style>

    <div class="degrees-shell">
        <div class="degrees-top">
            <h1>Degrees</h1>
            <a href="{{ route('degrees.create') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-sky">
                <i class="fas fa-plus"></i> Add New Degree
            </a>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert-soft success">
                {{ $message }}
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert-soft error">
                {{ $message }}
            </div>
        @endif

        <div class="degree-card">
            @forelse($degrees as $degree)
                @if ($loop->first)
                    <div class="table-responsive">
                        <table class="degree-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Degree Title</th>
                                    <th>Total Students</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                @endif

                <tr>
                    <td>{{ ($degrees->currentPage() - 1) * $degrees->perPage() + $loop->iteration }}</td>
                    <td><strong>{{ $degree->title }}</strong></td>
                    <td><span class="degree-count">{{ $degree->students->count() }}</span></td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('degrees.show', $degree->id) }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-view">View</a>
                            <a href="{{ route('degrees.edit', $degree->id) }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-edit">Edit</a>
                            <form method="POST" action="{{ route('degrees.destroy', $degree->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>

                @if ($loop->last)
                            </tbody>
                        </table>
                    </div>
                @endif
            @empty
                <div class="empty-state">
                    No degrees found. <a href="{{ route('degrees.create') }}" data-ajax-link="true" data-target="#ajaxPageContent">Add one now</a>
                </div>
            @endforelse
        </div>

        @if($degrees->count() > 0)
            <div class="pagination-wrap d-flex justify-content-center">
                {{ $degrees->links() }}
            </div>
        @endif
    </div>
@endsection
