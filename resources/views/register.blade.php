@extends('layout')
@section('content')
    <div class="container">
        <form style="width: 400px" class="me-auto ms-auto mt-3" method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-4">

                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name"
                    autocomplete="off">
                @error('first_name')
                    <span class=" d-block fs-6 text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">

                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name"
                    autocomplete="off">
                @error('last_name')
                    <span class=" d-block fs-6 text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">

                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                    autocomplete="off">
                @error('email')
                    <span class=" d-block fs-6 text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">

                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                @error('password')
                    <span class=" d-block fs-6 text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Confirm Password">
            </div>

            <button type="submit" class="btn">Register</button>

            <div class="mt-3 register-link">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
    <style>
        /* Add custom styles for the login page here */
        body {
            background-color: #E5F2F7;
            /* Light Blue background color */
        }

        .container {
            background-color: #f7f7f7;
            /* White container background color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin-top: 180px;
        }

        .btn {
            background-color: #348fff;
            /* Blue submit button color */
            color: #FFFFFF;
            width: 100%;
            /* White text color */
        }

        .register-link {
            margin-left: 80px;
        }
    </style>
@endsection
