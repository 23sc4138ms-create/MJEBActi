@extends('format.layout')

@section('title', 'Admin Dashboard')

@section('Content')
<style>
    /* ── STAT CARDS ── */
    .admin-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.4rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        border: 1px solid #d9efff;
    }
    .admin-card .section-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #7aaed3;
        margin-bottom: 1rem;
    }
    .admin-top {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .admin-avatar {
        width: 92px; height: 92px;
        border-radius: 18px;
        background: linear-gradient(135deg, #0ea5ff, #38bdf8);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
        box-shadow: 0 10px 24px rgba(14,165,255,0.22);
    }
    .admin-meta h2 {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.65rem;
        font-weight: 800;
        color: #0b2540;
    }
    .admin-meta .role {
        display: inline-flex;
        margin-top: 0.45rem;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
        background: #e0f7ff;
        color: #0369a1;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.4px;
    }
    .admin-details {
        margin-top: 1rem;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.75rem;
    }
    .detail-item {
        background: #f8fcff;
        border: 1px solid #d9efff;
        border-radius: 12px;
        padding: 0.8rem 0.9rem;
    }
    .detail-item .label {
        display: block;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #7aaed3;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .detail-item .value {
        font-size: 0.92rem;
        font-weight: 600;
        color: #10324a;
        word-break: break-word;
    }
    .admin-actions {
        margin-top: 1rem;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .admin-actions a {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.72rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.86rem;
    }
    .admin-actions .primary-btn {
        background: linear-gradient(135deg, #0ea5ff, #38bdf8);
        color: #fff;
        box-shadow: 0 10px 20px rgba(14,165,255,0.18);
    }
    .admin-actions .ghost-btn {
        background: #f8fcff;
        color: #0369a1;
        border: 1px solid #d9efff;
    }

    @media (max-width: 768px) {
        .admin-details { grid-template-columns: 1fr; }
    }
</style>

{{-- ── HERO ── --}}
<div class="dash-hero" style="margin-bottom:1.5rem;">
    <div style="position:relative;z-index:2;">
        <h1 style="color:white;margin:0;font-size:1.75rem;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;">
            <i class="fas fa-shield-alt me-2" style="opacity:.85;"></i>Admin Dashboard
        </h1>
        <p style="color:rgba(255,255,255,0.82);margin:0.35rem 0 0;font-size:0.92rem;">
            Welcome back, <strong>{{ session('username') }}</strong> — here's your system overview.
        </p>
    </div>
</div>

<div class="admin-card">
    <div class="section-label">Admin Details</div>
    <div class="admin-top">
        <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
        <div class="admin-meta">
            <h2>{{ session('username') ?? 'Admin' }}</h2>
            <div class="role">ADMIN</div>
        </div>
    </div>

    <div class="admin-details">
        <div class="detail-item">
            <span class="label">Username</span>
            <div class="value">{{ session('username') ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <span class="label">Email</span>
            <div class="value">{{ session('email') ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <span class="label">Role</span>
            <div class="value">Administrator</div>
        </div>
        <div class="detail-item">
            <span class="label">Status</span>
            <div class="value">Active</div>
        </div>
    </div>

    <div class="admin-actions">
        <a href="{{ route('password.change') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="primary-btn">
            <i class="fas fa-key"></i> Change Password
        </a>
        <a href="{{ route('logout') }}" class="ghost-btn">
            <i class="fas fa-right-from-bracket"></i> Logout
        </a>
    </div>
</div>
@endsection
