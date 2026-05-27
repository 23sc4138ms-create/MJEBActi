<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .report-date {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #366092;
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Course Report</h2>
    <div class="report-date">Generated on: {{ date('F d, Y H:i:s') }}</div>

    <table>
        <thead>
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
                <td>{{ $course->created_at->format('M d, Y H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
