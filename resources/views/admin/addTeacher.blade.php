@extends('format.layout')

@section('title', 'Add Teacher')

@section('Content')
    <div>
        <h2 style="margin-bottom:1rem;">Add New Teacher</h2>

        @if ($errors->any())
            <div style="color:#c00;margin-bottom:1rem;">
                <strong>Error:</strong>
                <ul style="margin:0;padding-left:1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.store.teacher') }}" method="POST" novalidate data-ajax="true" data-reset-on-success="true" style="max-width:720px;">
            @csrf

            <div style="margin-bottom:1rem;">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" style="display:block;width:100%;padding:.5rem;border:1px solid #ccc;border-radius:4px;">
                @error('name')<div style="color:#c00;margin-top:.25rem;">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:1rem;">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" style="display:block;width:100%;padding:.5rem;border:1px solid #ccc;border-radius:4px;">
                @error('email')<div style="color:#c00;margin-top:.25rem;">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:1rem;">
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" required value="{{ old('username') }}" style="display:block;width:100%;padding:.5rem;border:1px solid #ccc;border-radius:4px;">
                @error('username')<div style="color:#c00;margin-top:.25rem;">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:1rem;">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required style="display:block;width:100%;padding:.5rem;border:1px solid #ccc;border-radius:4px;">
                <small style="color:#666;display:block;margin-top:.25rem;">Password must be at least 8 characters long.</small>
                @error('password')<div style="color:#c00;margin-top:.25rem;">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" style="padding:.5rem 1rem;background:#0288d1;color:#fff;border:none;border-radius:4px;">Add Teacher</button>
                <a href="{{ route('admin.dashboard') }}" data-ajax-link="true" data-target="#ajaxPageContent" style="padding:.5rem 1rem;background:#6c757d;color:#fff;border-radius:4px;text-decoration:none;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
