@extends('layout')
@section('content')
    <main>
        <div class="me-auto ms-auto cont" style="width: 400px">
            <div class="custom-alert">
                <p>
                    Please enter your new password below to reset your password.</p>
            </div>

            <div class="container me-auto ms-auto mt-3" style="width: 400px">
                <form method="POST" action="{{ route('reset.password.post') }}">
                    @csrf
                    <input type="text" name="token" hidden value="{{ $token }}">
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Re-enter your email" autocomplete="off">
                        @error('email')
                            <span class=" d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="email" name="password"
                            placeholder="Enter new password">
                        @error('password')
                            <span class=" d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="email" name="password_confirmation"
                            placeholder="Confirm new password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </main>
    <style>
        .container {
            background-color: #FFFFFF;
            /* White container background color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .custom-alert {
            background-color: #007BFF;
            /* Blue background color */
            color: #FFFFFF;
            /* White text color */
            border-color: #0056b3;
            padding: 10px;
            /* Darker blue border color */

        }

        .cont {
            margin-top: 200px;
        }
    </style>
@endsection
