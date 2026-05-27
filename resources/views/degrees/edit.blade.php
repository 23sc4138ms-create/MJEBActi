@extends('format.layout')

@section('title', 'Edit Degree')

@section('Content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Edit Degree</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('degrees.index') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn btn-secondary">Back</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div>
        <form method="POST" action="{{ route('degrees.update', $degree->id) }}">
            @csrf
            @method('PUT')

            <div>
                <label for="title">Degree Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $degree->title) }}" required style="display:block;padding:.5rem;width:100%;border:1px solid #ccc;border-radius:4px;">
                @error('title')
                    <div style="color:#c00;margin-top:.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top:1rem;display:flex;gap:1rem;">
                <button type="submit" class="btn btn-link" style="padding:.5rem 1rem;background:#0288d1;color:#fff;border-radius:4px;border:none">Update</button>
                <a href="{{ route('degrees.index') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn btn-link" style="padding:.5rem 1rem;background:#6c757d;color:#fff;border-radius:4px;text-decoration:none;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
