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
    <h2>User Report</h2>
    <div class="report-date">Generated on: {{ date('F d, Y H:i:s') }}</div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username ?? '-' }}</td>
                <td>{{ $user->email ?? '-' }}</td>
                <td>{{ ucfirst((string) ($user->role ?? '-')) }}</td>
                <td>{{ (int) ($user->is_active ?? 0) === 1 ? 'Active' : 'Inactive' }}</td>
                <td>{{ $user->created_at ? $user->created_at->format('M d, Y H:i:s') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No user account data found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
