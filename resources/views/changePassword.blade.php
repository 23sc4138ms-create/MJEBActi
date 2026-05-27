@extends('format.layout')

@php($role = strtolower((string) session('role')))

@section('title', $role === 'teacher' ? 'Teacher Password Update - Student Management Dashboard' : ($role === 'student' ? 'Student Password Update - Student Management Dashboard' : 'Update Password - Student Management Dashboard'))

@section('Content')
    <style>
        .password-shell {
            max-width: 1080px;
            margin: 0 auto;
        }
        .password-hero {
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            background: linear-gradient(135deg, #0ea5ff 0%, #0369a1 100%);
            color: #fff;
            padding: 1.4rem 1.5rem;
            box-shadow: 0 18px 40px rgba(14,165,255,0.16);
            margin-bottom: 1.2rem;
        }
        .password-hero::after {
            content: '';
            position: absolute;
            inset: auto -40px -70px auto;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .password-hero h1 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.9rem;
            font-weight: 800;
            color: #fff;
        }
        .password-hero p {
            margin: 0.35rem 0 0;
            color: rgba(255,255,255,0.88);
            font-size: 0.96rem;
        }
        .password-grid {
            display: flex;
            gap: 1.25rem;
            align-items: stretch;
            flex-wrap: wrap;
        }
        .password-panel,
        .password-card {
            border-radius: 20px;
            background: #fff;
            border: 1px solid #d9efff;
            box-shadow: 0 10px 30px rgba(3,105,161,0.08);
            overflow: hidden;
        }
        .password-panel {
            flex: 1 1 320px;
            padding: 1.5rem;
        }
        .password-panel .eyebrow {
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
        .password-panel h2 {
            margin: 1rem 0 0.5rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.55rem;
            font-weight: 800;
            color: #0b2540;
        }
        .password-panel p {
            margin: 0;
            color: #4b5563;
            line-height: 1.65;
        }
        .password-checklist {
            margin: 1.1rem 0 0;
            padding: 0;
            list-style: none;
        }
        .password-checklist li {
            display: flex;
            gap: 0.65rem;
            align-items: flex-start;
            padding: 0.7rem 0;
            color: #0f172a;
            border-top: 1px solid #edf5fb;
        }
        .password-checklist li:first-child {
            border-top: 0;
            padding-top: 0;
        }
        .password-checklist i {
            color: #0ea5ff;
            margin-top: 0.2rem;
        }
        .password-card {
            flex: 1 1 420px;
        }
        .password-card-head {
            padding: 1.2rem 1.4rem;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
        }
        .password-card-head h2 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: #fff;
        }
        .password-card-head p {
            margin: 0.3rem 0 0;
            font-size: 0.92rem;
            color: rgba(255,255,255,0.9);
        }
        .password-card-body {
            padding: 1.4rem;
        }
        .password-card-body .form-label {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.88rem;
        }
        .password-card-body .form-control {
            border: 1px solid #cdeeff;
            border-radius: 10px;
            background: #f8fcff;
            box-shadow: none;
        }
        .password-card-body .form-control:focus {
            border-color: #0ea5ff;
            box-shadow: 0 0 0 3px rgba(14,165,255,0.10);
        }
        .password-actions {
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
        .alert-soft.success { background: #eff8ff; border: 1px solid #93c5fd; color: #0369a1; }
        .alert-soft.info { background: #f8fcff; border: 1px solid #cdeeff; color: #0369a1; }

        @media (max-width: 768px) {
            .password-panel,
            .password-card {
                flex-basis: 100%;
            }
            .password-hero {
                padding: 1.2rem;
            }
            .password-hero h1 {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="password-shell">
        <div class="password-hero">
            <h1>{{ $role === 'teacher' ? 'Teacher Password Update' : ($role === 'student' ? 'Student Password Update' : 'Update Password') }}</h1>
            <p>{{ $role === 'teacher' ? 'Keep your teacher account protected with a fresh password.' : ($role === 'student' ? 'Keep your student account protected with a fresh password.' : 'Set a new password to keep your account secure and ready for use.') }}</p>
        </div>

        <div class="password-grid">
            <div class="password-panel">
                <span class="eyebrow"><i class="fas fa-shield-halved"></i> Security first</span>
                <h2>{{ $role === 'teacher' ? 'Protect your teacher account' : ($role === 'student' ? 'Protect your student account' : 'Choose a stronger password') }}</h2>
                <p>{{ $role === 'teacher' ? 'Use a password that is easy for you to remember, but hard for others to guess.' : ($role === 'student' ? 'Use a password that is easy for you to remember, but hard for others to guess.' : 'Use a password that is easy for you to remember, but hard for others to guess.') }}</p>

                <ul class="password-checklist">
                    <li><i class="fas fa-circle-check"></i><span>Use at least 8 characters.</span></li>
                    <li><i class="fas fa-circle-check"></i><span>Mix letters, numbers, and symbols when possible.</span></li>
                    <li><i class="fas fa-circle-check"></i><span>Avoid using the same password on other accounts.</span></li>
                </ul>
            </div>

            <div class="password-card">
                <div class="password-card-head">
                    <h2><i class="fas fa-key me-2"></i>{{ $role === 'teacher' ? 'Teacher Password Form' : ($role === 'student' ? 'Student Password Form' : 'Password Update Form') }}</h2>
                    <p>{{ $role === 'teacher' ? 'Type your current password, then save a new one for your teacher account.' : ($role === 'student' ? 'Type your current password, then save a new one for your student account.' : 'Enter your current password, then choose a new one.') }}</p>
                </div>

            <div class="password-card-body">
                <p class="text-muted mb-4">{{ $role === 'teacher' ? 'Complete the form below to update your teacher password.' : ($role === 'student' ? 'Complete the form below to update your student password.' : 'Please complete the form below to save your new password.') }}</p>

                @if ($errors->any())
                    <div class="alert-soft danger">
                        @foreach ($errors->all() as $error)
                            <div class="mb-2">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert-soft success">{{ session('success') }}</div>
                @endif

                @if (session('info'))
                    <div class="alert-soft info">{{ session('info') }}</div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current password *</label>
                        <input
                            type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            id="current_password"
                            name="current_password"
                            placeholder="Type your current password"
                            autocomplete="current-password"
                            required>
                        @error('current_password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New password *</label>
                        <input
                            type="password"
                            class="form-control @error('new_password') is-invalid @enderror"
                            id="new_password"
                            name="new_password"
                            placeholder="Create a new password"
                            autocomplete="new-password"
                            required>
                        @error('new_password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">Use at least 8 characters.</small>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirm new password *</label>
                        <input
                            type="password"
                            class="form-control @error('confirm_password') is-invalid @enderror"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Retype your new password"
                            autocomplete="new-password"
                            required>
                        @error('confirm_password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="password-actions mb-3">
                        <button type="submit" class="btn-sky">Save password</button>
                        <a href="{{ route('home') }}" class="btn-soft">Back to dashboard</a>
                    </div>
                </form>

            </div>
            </div>
        </div>
    </div>
@endsection
