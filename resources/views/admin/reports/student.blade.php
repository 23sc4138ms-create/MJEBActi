@extends('format.layout')

@section('Content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Student Report</h2>
                <div>
                    <a href="{{ route('admin.reports.student.pdf') }}" class="btn btn-danger btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.reports.student.excel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
            </div>

            <table class="table table-striped">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Age</th>
                        <th>Degree</th>
                        <th>Course</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ trim(($student->fname ?? '') . ' ' . ($student->mname ?? '') . ' ' . ($student->lname ?? '')) ?: '-' }}</td>
                        <td>{{ $student->email ?? ($student->userAccount->email ?? '-') }}</td>
                        <td>{{ $student->contact_no ?? '-' }}</td>
                        <td>{{ $student->age ?? '-' }}</td>
                        <td>{{ $student->degree ? $student->degree->title : '-' }}</td>
                        <td>{{ $student->courses->pluck('course_name')->implode(', ') ?: ($student->course ?? '-') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No student data found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
