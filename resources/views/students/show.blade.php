@extends('format.layout')

@section('title', $student->fname . ' ' . $student->lname . ' - Student Details')

@section('Content')
    <style>
        .student-detail-shell {
            max-width: 820px;
            margin: 0 auto;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.65rem 0.95rem;
            border: 1px solid #cdeeff;
            border-radius: 10px;
            background: #f8fcff;
            color: #0369a1;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 1rem;
        }
        .student-detail-card {
            background: #fff;
            border: 1px solid #d9efff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 34px rgba(14,165,255,0.08);
        }
        .student-detail-head {
            padding: 1.2rem 1.4rem;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
        }
        .student-detail-head h3 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.45rem;
            font-weight: 800;
            color: #fff;
        }
        .student-detail-head p {
            margin: 0.3rem 0 0;
            color: rgba(255,255,255,0.88);
            font-size: 0.88rem;
        }
        .student-detail-body { padding: 1.4rem; }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem;
        }
        .info-item {
            padding: 0.9rem 1rem;
            border: 1px solid #e3f4ff;
            border-radius: 12px;
            background: #f8fcff;
        }
        .info-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #7aaed3;
            margin-bottom: 0.3rem;
        }
        .info-value {
            color: #10324a;
            font-weight: 600;
            word-break: break-word;
        }
        .degree-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.7rem;
            border-radius: 999px;
            background: #e0f7ff;
            color: #0369a1;
            font-weight: 700;
            text-decoration: none;
        }
        .student-detail-footer {
            padding: 1rem 1.4rem;
            border-top: 1px solid #eef6fb;
            background: #f8fcff;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        .btn-sky,
        .btn-soft,
        .btn-danger-soft {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.72rem 1rem;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            border: 0;
        }
        .btn-sky { background: linear-gradient(135deg, #0ea5ff, #38bdf8); color: #fff; }
        .btn-soft { background: #e8f7ff; color: #0369a1; }
        .btn-danger-soft { background: #ffeef0; color: #b91c1c; }
        .alert-success-soft {
            background: #eff8ff;
            border: 1px solid #93c5fd;
            color: #0369a1;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="student-detail-shell">
        <a href="{{ route('students.index') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>

        @if ($message = Session::get('success'))
            <div class="alert-success-soft">
                <i class="fas fa-check-circle me-1"></i> {{ $message }}
            </div>
        @endif

        <div class="student-detail-card">
            <div class="student-detail-head">
                <h3><i class="fas fa-user-graduate me-2"></i>{{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}</h3>
                <p>Simple student detail view</p>
            </div>

            <div class="student-detail-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Degree</span>
                        <div class="info-value">
                            @if($student->degree)
                                <a href="{{ route('degrees.show', $student->degree->id) }}" class="degree-pill">{{ $student->degree->title }}</a>
                            @else
                                <span class="text-muted">No degree</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Username</span>
                        <div class="info-value"><i class="fas fa-user fa-sm me-1 text-muted"></i>{{ $student->userAccount?->username ?? '—' }}</div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <div class="info-value"><i class="fas fa-envelope fa-sm me-1 text-muted"></i>{{ $student->email }}</div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Contact Number</span>
                        <div class="info-value"><i class="fas fa-phone fa-sm me-1 text-muted"></i>{{ $student->contact_no }}</div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Student ID</span>
                        <div class="info-value">{{ $student->id }}</div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Last Updated</span>
                        <div class="info-value">{{ $student->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            <div class="student-detail-footer">
                <a href="{{ route('students.edit', $student->id) }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-sky">
                    <i class="fas fa-pen"></i> Edit Student
                </a>

                <button
                    type="button"
                    class="btn-danger-soft js-delete-student"
                    data-id="{{ $student->id }}"
                    data-name="{{ $student->lname }}, {{ $student->fname }}">
                    <i class="fas fa-trash"></i> Delete Student
                </button>
            </div>
        </div>
    </div>
@endsection
