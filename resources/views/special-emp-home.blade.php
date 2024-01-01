@extends('layout')
@section('content')
    <div id="notifications-container"></div>

    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="row">
                    <!-- Profile Container -->
                    <div class="col-md-6">
                        <div class="profile-container">
                            <div class="profile-header">
                                <h2>Profile</h2>
                                <p>First Name: {{ $user->first_name }}</p>
                                <p>Last Name: {{ $user->last_name }}</p>
                                <p>Email: {{ Auth::user()->email }}</p>
                                <p>Role: {{ $user->role }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Statistics Container -->
                    <div class="col-md-6">
                        <div class="statistics-container">
                            <h2>Statistics:</h2>
                            <ul>
                                <li>Total Users: {{ $users->count() }}</li>
                                <li>Total Pharmacists: {{ $pharmacists->count() }}</li>
                                <li>Total Pharmacies: {{ $pharmacies->count() }}</li>
                                <li>Total Customers: {{ $customers->count() }}</li>
                                <li>Total Special Employees: {{ $specialEmps->count() }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Styles for the profile container */
        .profile-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;

            /* Center the container horizontally */
            max-width: 500px;
        }

        .profile-header h2 {
            color: #007BFF;
            /* Blue header text color */
            margin-bottom: 10px;
        }

        .profile-header p {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Styles for the statistics container */
        .statistics-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;

            /* Center the container horizontally */
            max-width: 500px;
        }

        .statistics-container h2 {
            color: #007BFF;
            /* Blue header text color */
            margin-bottom: 10px;
        }

        .statistics-container ul {
            list-style-type: none;
            padding: 0;
        }

        .statistics-container li {
            margin-bottom: 5px;
            color: #555555;
            /* Gray text color */
        }

        .container {
            margin-top: 120px;
        }

        /* Custom styles for the sidebar */
    </style>
@endsection
