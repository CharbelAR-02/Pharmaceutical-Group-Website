<!DOCTYPE html>
<html>

<head>
    <title>Command Medications</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Command Medications</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>State</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medications as $medication)
                <tr>
                    <td>{{ $medication->name }}</td>
                    <td>{{ $medication->category }}</td>
                    <td>{{ $medication->state }}</td>
                    <td>{{ $medication->pivot->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
