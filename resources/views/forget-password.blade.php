@extends('layout')
@section('content')
    <main>

        <div class="me-auto ms-auto cont" style="width: 400px">
            <div class="custom-alert">
                We will send you an email with instructions on how to reset your password.
            </div>
            <div class="container me-auto ms-auto mt-3" style="width: 400px">
                <form method="POST" action="{{ route('forget.password.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Write Your Email Here:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                            autocomplete="off">
                        @error('email')
                            <span class=" d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
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
            margin-top: 250px;
        }
    </style>
@endsection
