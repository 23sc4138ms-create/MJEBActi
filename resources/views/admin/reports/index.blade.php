@extends('format.layout')

@section('Content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Reports</h2>
        </div>
    </div>

    <div class="row">
        <!-- Student Report Card -->
        <div class="col-md-4 mb-4">
            <div class="card" style="border: 1px solid #e0e0e0;">
                <div class="card-body">
                    <h5 class="card-title">Student Report</h5>
                    <p class="card-text">Generate student records in PDF or Excel format.</p>
                    <a href="{{ route('admin.reports.student') }}" class="btn btn-primary btn-sm">View Report</a>
                </div>
            </div>
        </div>

        <!-- User Report Card -->
        <div class="col-md-4 mb-4">
            <div class="card" style="border: 1px solid #e0e0e0;">
                <div class="card-body">
                    <h5 class="card-title">User Report</h5>
                    <p class="card-text">Generate user records in PDF or Excel format.</p>
                    <a href="{{ route('admin.reports.user') }}" class="btn btn-primary btn-sm">View Report</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
