@extends('format.layout')

@section('title', $degree->title . ' - Degree Details')

@section('Content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $degree->title }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('degrees.index') }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <div>
        <section style="margin-bottom:1.25rem;">
            <h3>Degree Information</h3>
            <p><strong>Degree Title:</strong> {{ $degree->title }}</p>
            <p><strong>Total Students:</strong> {{ $degree->students->count() }}</p>
            <p><strong>Created:</strong> {{ $degree->created_at->format('M d, Y H:i A') }}</p>
            <p><strong>Last Updated:</strong> {{ $degree->updated_at->format('M d, Y H:i A') }}</p>
            <div>
                <a href="{{ route('degrees.edit', $degree->id) }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn btn-link">Edit</a>
                <form method="POST" action="{{ route('degrees.destroy', $degree->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger">Delete</button>
                </form>
            </div>
        </section>

        <section>
            <h3>Students Enrolled</h3>
            @if($degree->students->count() > 0)
                <div class="table-responsive">
                    <table class="table" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Age</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($degree->students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->contact_no }}</td>
                                    <td>{{ $student->age }}</td>
                                    <td>
                                        <a href="{{ route('students.show', $student->id) }}" data-ajax-link="true" data-target="#ajaxPageContent" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No students are currently enrolled in this degree.</p>
            @endif
        </section>
    </div>
@endsection
