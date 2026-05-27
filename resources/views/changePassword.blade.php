@extends('format.layout')

@section('title', 'Change Password - Student Management Dashboard')

@section('Content')
    <style>
        .password-shell {
            max-width: 760px;
            margin: 0 auto;
        }
        .password-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        .password-top h1 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0b2540;
        }
        .password-card {
            background: #fff;
            border: 1px solid #d9efff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 34px rgba(14,165,255,0.08);
        }
        .password-card-head {
            padding: 1.15rem 1.4rem;
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
            font-size: 0.9rem;
            color: rgba(255,255,255,0.88);
        }
        .password-card-body { padding: 1.4rem; }
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
            margin-top: 0.5rem;
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
    </style>

    <div class="password-shell">
        <div class="password-top">
            <h1>Change Password</h1>
        </div>

        <div class="password-card">
            <div class="password-card-head">
                <h2><i class="fas fa-key me-2"></i>Change Password</h2>
                <p>Simple and secure password update form.</p>
            </div>

            <div class="password-card-body">
                <p class="text-muted mb-4">Update your password to keep your account secure.</p>

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
                        <label for="current_password" class="form-label">Current Password *</label>
                        <input
                            type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            id="current_password"
                            name="current_password"
                            placeholder="Enter your current password"
                            autocomplete="current-password"
                            required>
                        @error('current_password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password *</label>
                        <input
                            type="password"
                            class="form-control @error('new_password') is-invalid @enderror"
                            id="new_password"
                            name="new_password"
                            placeholder="Enter your new password"
                            autocomplete="new-password"
                            required>
                        @error('new_password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">Password must be at least 8 characters long</small>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirm Password *</label>
                        <input
                            type="password"
                            class="form-control @error('confirm_password') is-invalid @enderror"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Confirm your new password"
                            autocomplete="new-password"
                            required>
                        @error('confirm_password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="password-actions mb-3">
                        <button type="submit" class="btn-sky">Update Password</button>
                        <a href="{{ route('home') }}" class="btn-soft">Back to Dashboard</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
