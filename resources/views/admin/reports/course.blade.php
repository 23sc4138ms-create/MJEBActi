@extends('format.layout')

@section('Content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Course Report</h2>
                <div>
                    <a href="{{ route('admin.reports.course.pdf') }}" class="btn btn-danger btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.reports.course.excel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
            </div>

            <table class="table table-striped">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th>ID</th>
                        <th>Course Name</th>
                        <th>Total Students</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->course_name ?? '-' }}</td>
                        <td>{{ $course->students ? count($course->students) : 0 }}</td>
                        <td>{{ $course->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
