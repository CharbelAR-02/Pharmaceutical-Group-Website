@extends('layout')

@section('content')
    <div class="container access-denied">
        <div class="row justify-contesnt-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Access Denied</div>
                    <div class="card-body">
                        <p>You are already authenticated and cannot access the login or register page.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .access-denied {
            margin-top: 290px;
            margin-left: 160px;
        }
    </style>
@endsection
