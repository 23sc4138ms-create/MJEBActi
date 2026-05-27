@extends('format.layout')

@section('title', 'Teacher Dashboard')

@section('Content')
    <style>
        .teacher-shell {
            max-width: 1080px;
            margin: 0 auto;
        }
        .teacher-hero {
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            background: linear-gradient(135deg, #0ea5ff 0%, #0369a1 100%);
            color: #fff;
            padding: 1.4rem 1.5rem;
            box-shadow: 0 18px 40px rgba(14,165,255,0.16);
            margin-bottom: 1.2rem;
        }
        .teacher-hero::after {
            content: '';
            position: absolute;
            inset: auto -40px -70px auto;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .teacher-hero h1 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.9rem;
            font-weight: 800;
            color: #fff;
        }
        .teacher-hero p {
            margin: 0.35rem 0 0;
            color: rgba(255,255,255,0.88);
            font-size: 0.96rem;
        }
        .teacher-card {
            background: #fff;
            border: 1px solid #d9efff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(3,105,161,0.08);
        }
        .teacher-card-head {
            padding: 1.2rem 1.4rem;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
        }
        .teacher-card-head h2 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: #fff;
        }
        .teacher-card-head p {
            margin: 0.3rem 0 0;
            font-size: 0.92rem;
            color: rgba(255,255,255,0.9);
        }
        .teacher-card-body {
            padding: 1.4rem;
        }
        .teacher-credentials {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem;
        }
        .credential-item {
            background: #f8fcff;
            border: 1px solid #d9efff;
            border-radius: 14px;
            padding: 0.95rem 1rem;
        }
        .credential-item .label {
            display: block;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #7aaed3;
            margin-bottom: 0.25rem;
        }
        .credential-item .value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            word-break: break-word;
        }
        .teacher-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 1.2rem;
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

        @media (max-width: 768px) {
            .teacher-credentials {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="teacher-shell">
        <div class="teacher-hero">
            <h1>Teacher Dashboard</h1>
            <p>View your account credentials and update your password when needed.</p>
        </div>

        <div class="teacher-card">
            <div class="teacher-card-head">
                <h2><i class="fas fa-user-shield me-2"></i>Teacher Credentials</h2>
                <p>Your account details are shown below for quick reference.</p>
            </div>

            <div class="teacher-card-body">
                <div class="teacher-credentials">
                    <div class="credential-item">
                        <span class="label">Teacher Name</span>
                        <div class="value">{{ $teacher->name ?? $teacher->username ?? 'N/A' }}</div>
                    </div>
                    <div class="credential-item">
                        <span class="label">Username</span>
                        <div class="value">{{ $teacher->username ?? 'N/A' }}</div>
                    </div>
                    <div class="credential-item">
                        <span class="label">Email</span>
                        <div class="value">{{ $teacher->email ?? 'N/A' }}</div>
                    </div>
                    <div class="credential-item">
                        <span class="label">Role</span>
                        <div class="value">{{ ucfirst((string) $teacher->role) }}</div>
                    </div>
                    <div class="credential-item">
                        <span class="label">Status</span>
                        <div class="value">{{ (int) ($teacher->is_active ?? 0) === 1 ? 'Active' : 'Inactive' }}</div>
                    </div>
                    <div class="credential-item">
                        <span class="label">Password Action</span>
                        <div class="value">Use the Password button to update your access.</div>
                    </div>
                </div>

                <div class="teacher-actions">
                    <a href="{{ route('password.change') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-sky">Change Password</a>
                    <a href="{{ route('logout') }}" class="btn-soft">Logout</a>
                </div>
            </div>
        </div>
    </div>
@endsection
