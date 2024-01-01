@extends('layout')
@section('header')
    <script>
        $(document).ready(function() {
            var command = {!! json_encode($command) !!}; // Get the command object from your Blade template

            if (command === null) {
                // Show the empty cart message
                $('#emptyCartMessage').show();
            }
            console.log($('#cartTable tbody tr').length);
        });

        function deleteItem(commandMedId) {

            $.ajax({
                url: "{{ route('cart.delete') }}",
                type: "get",
                data: {
                    commandMedId: commandMedId,
                    commandId: $('#commandmed_' + commandMedId).attr('data-command-id'),

                },
                success: function(output) {
                    $('.alert-success').html(output.success);
                    $('.alert-success').fadeIn().delay(2000).fadeOut();
                    $("#row_" + commandMedId).fadeOut('slow', function() {
                        $(this).remove();
                    });


                    if ($('#cartTable tbody tr').length === 2) {
                        console.log("hello");
                        $('#cartTableContainer').hide(); // Hide the table
                        $('#emptyCartMessage').show(); // Show the message
                    }
                    $('#totalPrice').text('$' + output.newTotalPrice);

                }
            });
        }

        function cancelCommand(commandId) {
            $.ajax({
                url: "{{ route('cart.cancelCommand') }}",
                type: "get",
                data: {
                    id: commandId
                },
                success: function(response) {

                    if (response.success) {

                        $('.alert-success').html(response.success);
                        $('.alert-success').fadeIn().delay(2000).fadeOut();

                        $('#emptyCartMessage').show();
                        $('#cartTableContainer').hide();

                    } else {

                        console.log("Failed to cancel the command.");
                    }
                },
                error: function(xhr) {
                    // Handle any errors that occurred during the AJAX request
                    console.log('Error: ' + xhr.responseText);
                }
            });
        }

        function confirmCommand(commandId) {

            // Make an AJAX request to confirm the command
            $.ajax({
                url: "{{ route('cart.confirmCommand') }}",
                type: "get",
                data: {
                    id: commandId,
                },
                success: function(response) {
                    if (response.success) {
                        $('.alert-success').html(response.success);
                        $('.alert-success').fadeIn().delay(2000).fadeOut();
                        $('#emptyCartMessage').show();
                        $('#cartTableContainer').hide();
                    } else {
                        console.log("Failed to confirm the command.");
                    }
                },
                error: function(xhr) {
                    // Handle any errors that occurred during the AJAX request
                    console.log("Error: " + xhr.responseText);
                }
            });
        }
    </script>
@endsection
@section('content')
    <div class="container">
        <h1 class="my-4">Shopping Cart</h1>
        <div id="emptyCartMessage" style="display: none">
            Your cart is empty. Start shopping now!
        </div>

        <div id="cartTableContainer">
            @if (!$commandMedications->isEmpty())
                <table class="table table-bordered" id="cartTable">
                    <thead>
                        <tr>
                            <th>Medication Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Item Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cartItems">
                        @foreach ($commandMedications as $medication)
                            <tr id="row_{{ $medication->pivot->id }}">
                                <td>{{ $medication->name }}</td>
                                <td>{{ $medication->pivot->quantity }}</td>
                                <td>{{ $medication->pivot->unit_price }}</td>
                                <td>{{ $medication->pivot->item_total }}</td>
                                <td><button class="btn btn-danger" id="commandmed_{{ $medication->pivot->id }}"
                                        data-command-id="{{ $command->id }}"
                                        onclick="deleteItem({{ $medication->pivot->id }})">Delete</button>
                                </td>

                            </tr>
                        @endforeach

                        <tr>
                            <td colspan=2 style="text-align: center"><button class="btn btn-danger"
                                    onclick="cancelCommand({{ $command->id }})">Cancel
                                    Command</button></td>
                            <td colspan=3 style="text-align: center"><button class="btn btn-primary"
                                    onclick="confirmCommand({{ $command->id }})">Confirm
                                    Command</button></td>
                        </tr>

                    </tbody>
                </table>

                <div class="text-right">
                    <p><strong>Total: <span id="totalPrice">${{ $command->total_price }}</span></strong></p>
                </div>
            @endif

        </div>
    </div>
    <style>
        .container {
            margin-top: 80px;
        }
    </style>
@endsection
