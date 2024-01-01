@extends('layout')
@section('content')
    <div class="container">
        <form style="width: 400px" class="me-auto ms-auto mt-3" method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-outline mb-4">

                <input type="email" class="form-control" id="email" name="email" placeholder="Email Adress"
                    autocomplete="off">
                @error('email')
                    <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-outline mb-4">

                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                @error('password')
                    <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn mb-4">Login</button>

            <div class="forgot-link">
                <a href="{{ route('forget.password') }}" class="mb-4">Forget Password?</a>
            </div>
            <div class="mt-3 register-link">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
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
            margin-top: 250px;
        }

        .btn {
            background-color: #348fff;
            /* Blue submit button color */
            color: #FFFFFF;
            width: 100%;
            /* White text color */
        }

        .forgot-link {
            margin-left: 130px;
        }

        .register-link {
            margin-left: 80px;
        }
    </style>
@endsection
