@extends('format.layout')

@section('title', 'Students')

@section('Content')
<style>
    .students-shell {
        max-width: 1200px;
        margin: 0 auto;
    }
    .students-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }
    .students-title {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.55rem;
        font-weight: 800;
        color: #0b2540;
    }
    .btn-add-student {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.7rem 1rem;
        background: linear-gradient(135deg, #0ea5ff, #38bdf8);
        color: #fff;
        border: 0;
        border-radius: 10px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-add-student:hover { color: #fff; opacity: 0.96; }
</style>

<div class="students-shell">
    <div class="students-head">
        <h1 class="students-title">Students</h1>

        <a href="{{ route('students.create') }}"
           data-ajax-link="true"
           data-target="#ajaxPageContent"
           class="btn-add-student">
            <i class="fas fa-user-plus"></i> Add New Student
        </a>
    </div>

    <div id="studentTable" data-ajax-list-url="/students">
        @include('students.partials.table')
    </div>
</div>
@endsection
