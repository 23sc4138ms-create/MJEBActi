@extends('format.layout')

@section('title', 'Insert Teacher')

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
        .teacher-grid {
            display: flex;
            gap: 1.25rem;
            align-items: stretch;
            flex-wrap: wrap;
        }
        .teacher-panel,
        .teacher-card {
            border-radius: 20px;
            background: #fff;
            border: 1px solid #d9efff;
            box-shadow: 0 10px 30px rgba(3,105,161,0.08);
            overflow: hidden;
        }
        .teacher-panel {
            flex: 1 1 320px;
            padding: 1.5rem;
        }
        .teacher-panel .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0.65rem;
            border-radius: 999px;
            background: #eff8ff;
            color: #0369a1;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .teacher-panel h2 {
            margin: 1rem 0 0.5rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.55rem;
            font-weight: 800;
            color: #0b2540;
        }
        .teacher-panel p {
            margin: 0;
            color: #4b5563;
            line-height: 1.65;
        }
        .teacher-checklist {
            margin: 1.1rem 0 0;
            padding: 0;
            list-style: none;
        }
        .teacher-checklist li {
            display: flex;
            gap: 0.65rem;
            align-items: flex-start;
            padding: 0.7rem 0;
            color: #0f172a;
            border-top: 1px solid #edf5fb;
        }
        .teacher-checklist li:first-child {
            border-top: 0;
            padding-top: 0;
        }
        .teacher-checklist i {
            color: #0ea5ff;
            margin-top: 0.2rem;
        }
        .teacher-card {
            flex: 1 1 420px;
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
        .teacher-card-body { padding: 1.4rem; }
        .teacher-card-body .form-label {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.88rem;
        }
        .teacher-card-body .form-control {
            border: 1px solid #cdeeff;
            border-radius: 10px;
            background: #f8fcff;
            box-shadow: none;
        }
        .teacher-card-body .form-control:focus {
            border-color: #0ea5ff;
            box-shadow: 0 0 0 3px rgba(14,165,255,0.10);
        }
        .teacher-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 0.8rem;
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
            margin-bottom: 1rem;
        }
        .alert-soft.danger { background: #fff5f5; border: 1px solid #fecaca; color: #b91c1c; }

        @media (max-width: 768px) {
            .teacher-panel,
            .teacher-card {
                flex-basis: 100%;
            }
            .teacher-hero {
                padding: 1.2rem;
            }
            .teacher-hero h1 {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="teacher-shell">
        <div class="teacher-hero">
            <h1>Insert Teacher</h1>
            <p>Enter a new teacher account and keep your records organized.</p>
        </div>

        <div class="teacher-grid">
            <div class="teacher-panel">
                <span class="eyebrow"><i class="fas fa-user-plus"></i> New account setup</span>
                <h2>Prepare the teacher profile</h2>
                <p>Fill in the details below to create a secure teacher account for the system.</p>

                <ul class="teacher-checklist">
                    <li><i class="fas fa-circle-check"></i><span>Use a valid email address.</span></li>
                    <li><i class="fas fa-circle-check"></i><span>Choose a unique username.</span></li>
                    <li><i class="fas fa-circle-check"></i><span>Create a password with at least 8 characters.</span></li>
                </ul>
            </div>

            <div class="teacher-card">
                <div class="teacher-card-head">
                    <h2><i class="fas fa-chalkboard-user me-2"></i>Insert Teacher Form</h2>
                    <p>Complete the fields below to add a new teacher.</p>
                </div>

                <div class="teacher-card-body">
                    <p class="text-muted mb-4">Please provide the teacher details and save the account.</p>

        @if ($errors->any())
                    <div class="alert-soft danger">
                        <strong class="d-block mb-2">Please review the form:</strong>
                        <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                        </ul>
                    </div>
                @endif

                    <form action="{{ route('admin.store.teacher') }}" method="POST" novalidate data-ajax="true" data-reset-on-success="true">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Teacher name *</label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}" class="form-control" placeholder="Enter teacher name">
                            @error('name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address *</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}" class="form-control" placeholder="Enter teacher email">
                            @error('email')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username *</label>
                            <input type="text" id="username" name="username" required value="{{ old('username') }}" class="form-control" placeholder="Create a username">
                            @error('username')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" id="password" name="password" required class="form-control" placeholder="Create a password">
                            <small class="text-muted d-block mt-1">Use at least 8 characters.</small>
                            @error('password')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="teacher-actions">
                            <button type="submit" class="btn-sky">Insert Teacher</button>
                            <a href="{{ route('admin.dashboard') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-soft">Back to dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
