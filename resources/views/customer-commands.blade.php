@extends('layout')
@section('header')
    <script>
        function toggleCommand(id) {
            $("#command_" + id).toggle();
        }

        function arrived(id) {

            $('#arrived_' + id).attr('disabled', 'disabled');
            $.ajax({
                url: "{{ route('items.arrived') }}",
                data: {
                    commandId: id,
                },
                success: function(response) {
                    if (response.success) {
                        $('.alert-success').show();
                        $('.alert-success').html(response.success);
                        $('.alert-success').fadeIn().delay(2000).fadeOut();
                        $('#arrived_' + id).hide();
                        $('#status_' + id).text("Command status: " + response.status);
                        $('#arrived_at_' + id).text("Arrived at: " + response.arrived_at);
                    }

                }

            });

        }
    </script>
@endsection
@section('content')
    @if ($commands->isempty())
        <div class="container">
            <h1 class="my-4">Your Commands</h1>
            You have no commands at the moment. Start shopping to create one.
        </div>
    @endif
    <div class="container-fluid mt-5">
        <div class="row">
            @foreach ($commands as $command)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title" id="status_{{ $command->id }}">Command status:
                                {{ $command->status }}</h5>
                            <p class="card-text">Created at: {{ $command->created_at }}</p>
                            <p class="card-text">Shipped at: {{ $command->shipped_at ?? 'N/A' }}</p>
                            <p class="card-text" id="arrived_at_{{ $command->id }}">Arrived at:
                                {{ $command->arrived_at ?? 'N/A' }}</p>
                            <p><button class="btn-show-details" type="button"
                                    onclick="toggleCommand({{ $command->id }})">show
                                    details</button>
                            </p>
                            <div id="command_{{ $command->id }}" style="display:none;">
                                <h6 class="card-subtitle mb-2 text-muted">Medications:</h6>
                                <ul class="list-group">
                                    @foreach ($command->medications as $medication)
                                        <li class="list-group-item">
                                            Medication Name: {{ $medication->name }}<br>
                                            Medication Category: {{ $medication->category }}<br>
                                            Quantity: {{ $medication->pivot->quantity }}<br>
                                        </li>
                                    @endforeach
                                </ul>
                                @if ($command->status === 'shipped')
                                    <br>
                                    <button type="button" onclick="arrived({{ $command->id }})"
                                        id="arrived_{{ $command->id }}">medications arrivred</button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <style>
            .container-fluid {
                margin-left: 24px;
            }

            .card {
                border: 1px solid #ccc;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
                width: 500px;
                border-radius: 20px;
            }

            .card-body {
                background-color: #f9f9f9;
                padding: 20px;
            }

            .card-title {
                font-weight: bold;
                color: #333;
            }

            .card-subtitle {
                font-weight: bold;
            }

            .list-group-item {
                background-color: #fff;
                border: 1px solid #ccc;
                margin-top: 10px;
                padding: 10px;
            }

            .btn-show-details {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
            }

            .btn-show-details:hover {
                background-color: #0056b3;
            }

            .row {
                margin-top: 80px;
            }

            /* Add more styles as needed */
        </style>
    @endsection
