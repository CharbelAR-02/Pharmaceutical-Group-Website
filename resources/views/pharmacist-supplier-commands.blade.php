@extends('layout')
@section('header')
    <script>
        function toggleCommand(id) {
            $("#command_" + id).toggle();
        }

        function arrived(id) {

            $('#arrived_' + id).attr('disabled', 'disabled');
            $.ajax({
                url: "{{ route('pharmacist.supplier.items.arrived') }}",
                data: {
                    commandId: id,
                },
                success: function(response) {
                    if (response.success) {
                        $('#live-alert').html(response.success);
                        $('#live-alert').fadeIn().delay(2000).fadeOut();
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
    <div class="container-fluid mt-5">
        <div class="row">
            @forelse ($commands as $command)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title" id="status_{{ $command->id }}">Id: {{ $command->id }} status:
                                {{ $command->status }}</h6>
                            <p class="card-text">Created at: {{ $command->created_at }}</p>
                            <p class="card-text" id="arrived_at_{{ $command->id }}">Arrived at:
                                {{ $command->arrived_at ?? 'N/A' }}</p>

                            <p class="card-text">Supplier Full Name: {{ $command->supplier->first_name }}
                                {{ $command->supplier->last_name }}</p>
                            <p><button type="button" class="btn-show-details"
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
                                @if ($command->status === 'confirmed')
                                    <br>
                                    <button type="button" onclick="arrived({{ $command->id }})"
                                        id="arrived_{{ $command->id }}">Medications arrived</button>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    There are no commands to display.
                </div>
            @endforelse
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
                margin-top: 110px;
            }

            /* Add more styles as needed */
        </style>
    @endsection
