@extends('format.layout')

@section('title', 'Add Degree')

@section('Content')
    <style>
        .degree-shell {
            max-width: 820px;
            margin: 0 auto;
        }
        .degree-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        .degree-top h1 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0b2540;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.65rem 0.95rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            color: #0369a1;
            background: #f8fcff;
            border: 1px solid #cdeeff;
        }
        .degree-card {
            background: #fff;
            border: 1px solid #d9efff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 34px rgba(14,165,255,0.08);
        }
        .degree-card-head {
            padding: 1.15rem 1.4rem;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
        }
        .degree-card-head h2 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: #fff;
        }
        .degree-card-head p {
            margin: 0.3rem 0 0;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.88);
        }
        .degree-card-body {
            padding: 1.4rem;
        }
        .degree-card-body .form-label {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.88rem;
        }
        .degree-card-body .form-control {
            border: 1px solid #cdeeff;
            border-radius: 10px;
            background: #f8fcff;
            box-shadow: none;
        }
        .degree-card-body .form-control:focus {
            border-color: #0ea5ff;
            box-shadow: 0 0 0 3px rgba(14,165,255,0.10);
        }
        .degree-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }
        .btn-sky {
            border: 0;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            color: #fff;
            border-radius: 10px;
            font-weight: 700;
            padding: 0.72rem 1rem;
        }
        .btn-soft {
            border: 1px solid #cdeeff;
            background: #f8fcff;
            color: #0369a1;
            border-radius: 10px;
            font-weight: 700;
            padding: 0.72rem 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .alert-soft-danger {
            background: #fff5f5;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 10px;
            padding: 0.85rem 1rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="degree-shell">
        <div class="degree-top">
            <h1>Add New Degree</h1>
            <a href="{{ route('degrees.index') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert-soft-danger">
                <strong>Validation Error:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="degree-card">
            <div class="degree-card-head">
                <h2>Add New Degree</h2>
                <p>Simple form for degree records.</p>
            </div>

            <div class="degree-card-body">
                <form method="POST" action="{{ route('degrees.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Degree Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}"
                               placeholder="e.g., Bachelor of Science in Computer Science" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="degree-actions">
                        <button type="submit" class="btn-sky">Save Degree</button>
                        <a href="{{ route('degrees.index') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn-soft">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
