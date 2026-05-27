<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Management Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #0ea5ff;
            --primary-dark:  #0369a1;
            --primary-deep:  #075985;
            --primary-light: #7dd3fc;
            --primary-pale:  #e0f7ff;
            --primary-glow:  rgba(14,165,255,0.16);
            --radius:        12px;
            --shadow-sm:     0 2px 8px rgba(0,0,0,0.07);
            --shadow-md:     0 6px 24px rgba(0,0,0,0.10);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f3faff;
            font-family: 'DM Sans', sans-serif;
            color: #1a1a1a;
        }

        /* ── HEADER NAV ── */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-deep) 100%);
            box-shadow: 0 8px 24px rgba(3,105,161,0.14);
        }
        .site-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0));
            pointer-events: none;
        }
        .header-inner {
            position: relative;
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.85rem 1.25rem;
            flex-wrap: wrap;
        }
        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            flex-shrink: 0;
        }
        .header-brand .brand-text h2 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.08rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }
        .header-nav {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            flex: 1;
            flex-wrap: wrap;
            justify-content: center;
        }
        .header-nav a {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.58rem 0.85rem;
            color: rgba(255,255,255,0.9);
            border-radius: 999px;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s, color 0.15s, transform 0.15s;
            white-space: nowrap;
        }
        .header-nav a .nav-icon {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(255,255,255,0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            flex-shrink: 0;
        }
        .header-nav a:hover,
        .header-nav a:hover {
            background: rgba(255,255,255,0.14);
            color: #fff;
            transform: translateY(-1px);
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }
        .header-badge {
            background: var(--primary-pale);
            color: var(--primary-dark);
            font-size: 0.72rem;
            font-weight: 800;
            padding: 0.2rem 0.65rem;
            border-radius: 999px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .header-action {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 0.75rem;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            background: rgba(255,255,255,0.08);
            transition: background 0.15s, color 0.15s;
        }
        .header-action:hover {
            background: rgba(255,255,255,0.16);
            color: #fff;
        }

        /* ── MAIN WRAPPER ── */
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            flex: 1;
            padding: 1.5rem;
        }

        /* ── CARDS ── */
        .card {
            border: none;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            background: #fff;
            border-top: 3px solid var(--primary);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #f5ece3;
            color: var(--primary-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            padding: 1rem 1.25rem;
        }

        /* dashboard hero banner */
        .dash-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-deep) 100%);
            border-radius: var(--radius);
            padding: 2rem 2.25rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .dash-hero::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }
        .dash-hero::after {
            content: '';
            position: absolute;
            bottom: -60px; right: 80px;
            width: 150px; height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .dash-hero h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.75rem; font-weight: 800; margin: 0; color: #fff; }
        .dash-hero p  { color: rgba(255,255,255,0.85); margin: 0.4rem 0 0; }

        /* general helpers */
        h1,h2,h3 { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--primary-dark); }
        a { color: var(--primary-dark); }
        .btn-primary { background: var(--primary); border-color: var(--primary); font-weight: 600; border-radius: 8px; }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-sm { border-radius: 7px; font-weight: 600; }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            .header-inner {
                justify-content: flex-start;
            }
            .header-nav {
                order: 3;
                justify-content: flex-start;
                width: 100%;
            }
            .header-actions {
                margin-left: auto;
            }
        }
    </style>
</head>
<body>
    @php($hideChrome = trim($__env->yieldContent('hideChrome')) !== '')
    @php($role = strtolower((string) session('role')))
    @php($currentRoute = request()->route()?->getName() ?? '')

    @if (!$hideChrome)
        <header class="site-header">
            <div class="header-inner">
                <div class="header-brand">
                    <div class="brand-text">
                        <h2>Education</h2>
                    </div>
                </div>

                <nav class="header-nav">
                    @if ($role === 'admin')
                        <a href="{{ route('home') }}" data-ajax-link="true" data-target="#ajaxPageContent">
                            <span class="nav-icon"><i class="fas fa-tachometer-alt"></i></span> Dashboard
                        </a>
                        <a href="{{ route('students.index') }}" data-ajax-link="true" data-target="#ajaxPageContent">
                            <span class="nav-icon"><i class="fas fa-users"></i></span> Students
                        </a>
                        <a href="{{ route('degrees.index') }}" data-ajax-link="true" data-target="#ajaxPageContent">
                            <span class="nav-icon"><i class="fas fa-graduation-cap"></i></span> Degrees
                        </a>
                        <a href="{{ route('admin.reports.index') }}" data-ajax-link="true" data-target="#ajaxPageContent">
                            <span class="nav-icon"><i class="fas fa-file-pdf"></i></span> Reports
                        </a>
                        <a href="{{ route('admin.add.teacher') }}" data-ajax-link="true" data-target="#ajaxPageContent">
                            <span class="nav-icon"><i class="fas fa-chalkboard-user"></i></span> Add Teacher
                        </a>
                    @elseif ($role === 'teacher')
                        <a href="{{ route('teacher.dashboard') }}" data-ajax-link="true" data-target="#ajaxPageContent">
                            <span class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></span> Dashboard
                        </a>
                    @elseif ($role === 'student')
                        <a href="{{ route('student.dashboard') }}" data-ajax-link="true" data-target="#ajaxPageContent">
                            <span class="nav-icon"><i class="fas fa-user-graduate"></i></span> Dashboard
                        </a>
                    @endif
                </nav>

                <div class="header-actions">
                    @if(session('role'))
                        <span class="header-badge">{{ strtoupper(session('role')) }}</span>
                    @endif
                    @if(session('user_id'))
                        <a href="{{ route('password.change') }}" class="header-action" data-ajax-link="true" data-target="#ajaxPageContent">
                            <i class="fas fa-key"></i> Password
                        </a>
                        <a href="{{ route('logout') }}" class="header-action">
                            <i class="fas fa-right-from-bracket"></i> Logout
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <div class="page-wrapper">
            <main class="main-content">
                <div id="ajaxPageContent">
                    @yield('Content')
                </div>
            </main>
        </div>

    @else
        <div id="ajaxPageContent">
            @yield('Content')
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}?v=generic-autoreload-v2-20260520"></script>
</body>
</html>
