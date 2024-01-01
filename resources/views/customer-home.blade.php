@extends('layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="profile-container">
                    <div class="profile-header">
                        <h2>Profile</h2>
                        <p>First Name: {{ Auth::user()->first_name }}</p>
                        <p>Last Name: {{ Auth::user()->last_name }}</p>
                        <p>Email: {{ Auth::user()->email }}</p>
                        <p>Role: {{ Auth::user()->role }}</p>
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

        .row {
            margin-top: 120px;
        }
    </style>
@endsection
