<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"rel="stylesheet">

    <link href="{{ asset('css2/bootstrap.min.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="autocomplete" content="off">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Final Project</title>
    @yield('header')
    <style>
        body {
            background-color: #E5F2F7;
            font-family: Arial, sans-serif !important;
        }

        .custom-alert {
            border-radius: 10px;
        }

        .alert {
            position: fixed;
            /* Set the alerts to a fixed position */
            top: 60px;
            /* Adjust the top value to create space below the navbar */
            left: 50%;
            /* Center the alerts horizontally */
            transform: translateX(-50%);
            /* Center the alerts horizontally */
            z-index: 1000;
            /* Set a higher z-index value for alerts */
        }
    </style>
</head>

<body>



    @include('header')
    @include('special-employe-side-nav')
    @include('customer-pharmacist-home')
    @include('success-message')
    @include('error-message')
    @auth
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="text-center" style="width: 600px ; margin: auto;">
                <div id="live-alert" class="alert alert-success custom-alert" style="display: none;margin: 0 auto;">
                </div>
            </div>
            <div class="text-center" style="width: 600px ; margin: auto;">
                <div class="alert alert-danger custom-alert" style="display: none;margin: 0 auto;">
                </div>
            </div>
        @endauth

        @yield('content')
        @auth
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('Js/bootstrap.min.js') }}"></script>

</body>

</html>
