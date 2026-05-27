@extends('format.layout')

@section('title', 'Student Dashboard')

@section('Content')
    <style>
        .student-dash-shell {
            max-width: 1180px;
            margin: 0 auto;
        }
        .student-dash-hero {
            background: linear-gradient(135deg, #0ea5ff 0%, #166c9b 100%);
            border-radius: 18px;
            padding: 1.6rem 1.75rem;
            color: #fff;
            box-shadow: 0 14px 30px rgba(14,165,255,0.12);
            margin-bottom: 1.2rem;
        }
        .student-dash-hero h1 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
        }
        .student-dash-hero p {
            margin: 0.35rem 0 0;
            color: rgba(255,255,255,0.88);
            font-size: 0.95rem;
        }
        .student-dash-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
        }
        .student-card {
            background: #fff;
            border: 1px solid #d9efff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(14,165,255,0.06);
        }
        .student-card-head {
            padding: 0.95rem 1rem;
            border-bottom: 1px solid #eef6fb;
            color: #0b2540;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem;
            font-weight: 800;
        }
        .student-card-body {
            padding: 1rem;
            color: #334155;
        }
        .student-meta {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        .student-meta .item {
            display: flex;
            gap: 0.45rem;
            align-items: flex-start;
            font-size: 0.92rem;
        }
        .student-meta .label {
            font-weight: 700;
            color: #0f172a;
        }
        @media (max-width: 992px) {
            .student-dash-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="student-dash-shell">
        <div class="student-dash-hero">
            <h1>Welcome, {{ $student->fname }} {{ $student->lname }}</h1>
            <p>{{ $student->degree?->title ?? 'No degree assigned' }}</p>
        </div>

        <div class="student-dash-grid">
            <div class="student-card">
                <div class="student-card-head"><i class="fas fa-user me-2"></i>Personal Information</div>
                <div class="student-card-body">
                    <div class="student-meta">
                        <div class="item"><span class="label">Name:</span> <span>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</span></div>
                        <div class="item"><span class="label">Email:</span> <span>{{ $student->email }}</span></div>
                        <div class="item"><span class="label">Contact:</span> <span>{{ $student->contact_no }}</span></div>
                        <div class="item"><span class="label">Degree:</span> <span>{{ $student->degree?->title ?? 'Not assigned' }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
