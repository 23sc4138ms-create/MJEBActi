@extends('format.layout')

@section('title', 'Login — Education')

@section('hideChrome', '1')

@section('Content')
    @php($isLocked = $isLocked ?? false)
    @php($lockSecondsLeft = $lockSecondsLeft ?? null)

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            display: block !important;
            min-height: 100vh;
            background: linear-gradient(135deg, #e0f7ff 0%, #f8fcff 60%, #ffffff 100%) !important;
            font-family: 'DM Sans', sans-serif;
        }

        #ajaxPageContent { min-height: 100vh; }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background: rgba(255,255,255,0.94);
            border: 1px solid #d9efff;
            border-radius: 22px;
            box-shadow: 0 18px 40px rgba(14,165,255,0.10);
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            display: block;
            height: 4px;
            background: linear-gradient(90deg, #0ea5ff, #38bdf8);
        }

        .login-inner { padding: 1.7rem; }

        .login-brand {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 1.15rem;
        }

        .logo-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            color: #0b2540;
        }

        .brand-sub {
            font-size: 0.72rem;
            color: #6b9bbd;
            font-weight: 500;
        }

        .form-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            color: #0b2540;
            margin-bottom: 0.3rem;
        }

        .form-sub {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 1.4rem;
        }

        .field-group { margin-bottom: 1rem; }
        .field-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.35rem;
        }
        .field-wrap { position: relative; }
        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.85rem;
            pointer-events: none;
        }
        .field-wrap input {
            width: 100%;
            padding: 0.78rem 2.7rem 0.78rem 2.55rem;
            border: 1.5px solid #cdeeff;
            border-radius: 10px;
            background: #f8fcff;
            font-size: 0.92rem;
            color: #0f172a;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .field-wrap input:focus {
            border-color: #0ea5ff;
            box-shadow: 0 0 0 3px rgba(14,165,255,0.10);
            background: #fff;
        }
        .field-wrap:focus-within .field-icon { color: #0ea5ff; }

        .eye-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #9ca3af;
            font-size: 0.85rem;
            cursor: pointer;
            padding: 0;
        }
        .eye-toggle:hover { color: #0ea5ff; }

        .field-error { font-size: 0.75rem; color: #dc2626; margin-top: 0.3rem; }

        .btn-login {
            width: 100%;
            padding: 0.82rem 1rem;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(14,165,255,0.20);
            transition: transform 0.15s, box-shadow 0.2s, opacity 0.2s;
            margin-top: 0.4rem;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(14,165,255,0.24);
            opacity: 0.98;
        }

        .alert-custom {
            padding: 0.75rem 0.9rem;
            border-radius: 9px;
            font-size: 0.84rem;
            font-weight: 500;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }
        .alert-success-c { background: #eff8ff; border: 1px solid #93c5fd; color: #0369a1; }
        .alert-danger-c { background: #fff5f5; border: 1px solid #fecaca; color: #b91c1c; }
        .alert-custom button {
            margin-left: auto;
            border: 0;
            background: transparent;
            color: inherit;
            cursor: pointer;
            opacity: 0.65;
            padding: 0;
        }

        .login-footer-note {
            margin-top: 1.4rem;
            font-size: 0.75rem;
            color: #94a3b8;
            text-align: center;
        }

        .lock-screen { text-align: center; padding: 0.9rem 0 0.3rem; }
        .lock-icon-wrap {
            width: 74px;
            height: 74px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #f0f9ff, #dff2ff);
            color: #0369a1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }
        .lock-screen h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: #0b2540;
            margin-bottom: 0.35rem;
        }
        .lock-screen p { color: #64748b; font-size: 0.88rem; margin-bottom: 1.1rem; }
        .countdown-box {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            padding: 0.9rem 2rem;
            border-radius: 14px;
            border: 1px solid #cdeeff;
            background: #f8fcff;
        }
        #lockCountdown {
            font-family: 'Plus Jakarta Sans', monospace;
            font-size: 2.1rem;
            font-weight: 800;
            color: #0369a1;
            letter-spacing: 0.2rem;
        }
        .countdown-box small { margin-top: 0.2rem; font-size: 0.72rem; color: #94a3b8; font-weight: 700; }

        @media (max-width: 576px) {
            .login-wrapper { padding: 0.75rem; }
            .login-inner { padding: 1.25rem; }
            .form-heading { font-size: 1.55rem; }
        }
    </style>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-inner">
                <div class="login-brand">
                    <div class="logo-box"><i class="fas fa-graduation-cap"></i></div>
                    <div>
                        <div class="brand-name">Education</div>
                        <small class="brand-sub">Educational Management System</small>
                    </div>
                </div>

                <h2 class="form-heading">Welcome back</h2>
                <p class="form-sub">Sign in to continue to your dashboard.</p>

                @if ($isLocked)
                    <div class="lock-screen">
                        <div class="lock-icon-wrap"><i class="fas fa-lock"></i></div>
                        <h4>Account Temporarily Locked</h4>
                        <p>Too many failed login attempts.<br>Please wait before trying again.</p>
                        <div class="countdown-box">
                            <span id="lockCountdown">5:00</span>
                            <small>MINUTES REMAINING</small>
                        </div>
                    </div>

                    <script>
                        (function() {
                            const lockSecondsLeft = {{ $lockSecondsLeft }};
                            const startTime = Date.now();
                            const el = document.getElementById('lockCountdown');
                            let last = lockSecondsLeft;
                            function tick() {
                                const elapsed = Math.floor((Date.now() - startTime) / 1000);
                                const remaining = Math.max(0, lockSecondsLeft - elapsed);
                                if (remaining <= 0) { location.reload(); return; }
                                if (Math.floor(remaining) !== last) {
                                    last = Math.floor(remaining);
                                    const m = Math.floor(remaining / 60);
                                    const s = remaining % 60;
                                    el.textContent = m + ':' + (s < 10 ? '0' : '') + s;
                                }
                            }
                            tick();
                            setInterval(tick, 100);
                        })();
                    </script>
                @else
                    @if (session('success'))
                        <div class="alert-custom alert-success-c">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert-custom alert-danger-c">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </span>
                            <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('authenticate') }}" novalidate autocomplete="off">
                        @csrf

                        <div class="field-group">
                            <label for="username">Username</label>
                            <div class="field-wrap">
                                <i class="fas fa-user field-icon"></i>
                                <input type="text" id="username" name="username" placeholder="Enter your username" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" required>
                            </div>
                            @error('username')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="password">Password</label>
                            <div class="field-wrap">
                                <i class="fas fa-lock field-icon"></i>
                                <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="new-password" required>
                                <button type="button" class="eye-toggle" id="eyeToggle"><i class="fas fa-eye" id="eyeIcon"></i></button>
                            </div>
                            @error('password')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt" style="margin-right:0.4rem;"></i>Sign In
                        </button>
                    </form>

                    <p class="login-footer-note">Education &copy; {{ date('Y') }} &mdash; Educational Management System</p>

                    <script>
                        (function () {
                            const form = document.querySelector('form[action="{{ route('authenticate') }}"]');
                            const usernameEl = document.getElementById('username');
                            const passwordEl = document.getElementById('password');
                            const eyeToggle = document.getElementById('eyeToggle');
                            const eyeIcon = document.getElementById('eyeIcon');

                            if (eyeToggle) {
                                eyeToggle.addEventListener('click', function () {
                                    const isPwd = passwordEl.type === 'password';
                                    passwordEl.type = isPwd ? 'text' : 'password';
                                    eyeIcon.className = isPwd ? 'fas fa-eye-slash' : 'fas fa-eye';
                                });
                            }

                            const clearFields = () => {
                                if (form) form.reset();
                                if (usernameEl) usernameEl.value = '';
                                if (passwordEl) passwordEl.value = '';
                            };

                            window.addEventListener('pageshow', function (e) {
                                if (e.persisted) clearFields();
                            });

                            clearFields();
                        })();
                    </script>
                @endif
            </div>
        </div>
    </div>
@endsection
