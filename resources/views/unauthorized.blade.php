@extends('layout') <!-- You can extend your main layout here -->

@section('content')
    <div class="container unauthorized">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Unauthorized Access</div>
                    <div class="card-body">
                        <div class="text-center">
                            <h2 class="text-danger">Unauthorized Access</h2>
                            <p class="mb-4">You do not have permission to access this page.</p>
                            @if (Auth::check())
                                <p>You are authenticated, but you do not have permission to access this page.</p>
                            @else
                                <p>You are not authenticated. Please <a href="{{ route('login') }}">log in</a> to access this
                                    page.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .unauthorized {
            margin-top: 250px;
            /* Adjust this value as needed */
        }
    </style>
@endsection
