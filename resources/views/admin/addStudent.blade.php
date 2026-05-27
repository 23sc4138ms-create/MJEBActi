@extends('format.layout')

@section('title', 'Add Student')

@section('Content')
    <style>
        .student-form-shell {
            max-width: 760px;
            margin: 0 auto;
        }
        .student-form-card {
            background: #fff;
            border: 1px solid #d9efff;
            border-radius: 18px;
            box-shadow: 0 14px 34px rgba(14,165,255,0.08);
            overflow: hidden;
        }
        .student-form-head {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
        }
        .student-form-head h1 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
        }
        .student-form-head p {
            margin: 0.35rem 0 0;
            color: rgba(255,255,255,0.88);
            font-size: 0.9rem;
        }
        .student-form-body { padding: 1.5rem; }
        .student-form-body .form-label {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.88rem;
        }
        .student-form-body .form-control,
        .student-form-body .form-select {
            border: 1px solid #cdeeff;
            border-radius: 10px;
            background: #f8fcff;
            box-shadow: none;
        }
        .student-form-body .form-control:focus,
        .student-form-body .form-select:focus {
            border-color: #0ea5ff;
            box-shadow: 0 0 0 3px rgba(14,165,255,0.10);
        }
        .student-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }
        .btn-sky {
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
            border: 0;
            border-radius: 10px;
            font-weight: 700;
            padding: 0.72rem 1rem;
        }
        .btn-sky:hover { color: #fff; opacity: 0.96; }
        .btn-plain {
            border-radius: 10px;
            border: 1px solid #cdeeff;
            background: #f8fcff;
            color: #0369a1;
            font-weight: 700;
            padding: 0.72rem 1rem;
        }
    </style>

    <div class="student-form-shell">
        <div class="student-form-card">
            <div class="student-form-head">
                <h1><i class="fas fa-user-plus me-2"></i>Add New Student</h1>
                <p>Simple student entry form with blue style.</p>
            </div>

            <div class="student-form-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.store.student') }}" method="POST" novalidate data-ajax="true" data-loading="false" data-redirect="{{ route('students.index') }}" data-redirect-delay="0">
                    @csrf

                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name *</label>
                        <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" required value="{{ old('fname') }}">
                        @error('fname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control @error('mname') is-invalid @enderror" id="mname" name="mname" value="{{ old('mname') }}">
                        @error('mname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name *</label>
                        <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" required value="{{ old('lname') }}">
                        @error('lname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_no" class="form-label">Contact Number *</label>
                        <input type="text" class="form-control @error('contact_no') is-invalid @enderror" id="contact_no" name="contact_no" required value="{{ old('contact_no') }}">
                        @error('contact_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="degree_id" class="form-label">Degree *</label>
                        <select class="form-select @error('degree_id') is-invalid @enderror" id="degree_id" name="degree_id" required>
                            <option value="">-- Select Degree --</option>
                            @forelse(\App\Models\Degree::all() as $degree)
                                <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>
                                    {{ $degree->title }}
                                </option>
                            @empty
                                <option disabled>No degrees available</option>
                            @endforelse
                        </select>
                        @error('degree_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="student-actions">
                        <button type="submit" class="btn btn-sky">Add Student</button>
                        <a href="{{ route('admin.dashboard') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn btn-plain">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
