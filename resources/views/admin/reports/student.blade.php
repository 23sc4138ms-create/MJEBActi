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
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name ?? '-' }}</td>
                        <td>{{ $student->email ?? '-' }}</td>
                        <td>{{ $student->phone ?? '-' }}</td>
                        <td>{{ $student->age ?? '-' }}</td>
                        <td>{{ $student->degree ? $student->degree->name : '-' }}</td>
                        <td>{{ $student->course ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
