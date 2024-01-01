@extends('layout')
@section('header')
    <script>
        $(document).ready(function() {
            $('.price-input').hide();
            $('.btnUpdate').hide(); // Hide

            $(document).on('click', '.btnEdit', function() {
                var id = $(this).data('id');
                var priceSpan = $('#med-price_' + id);
                var editPrice = $('#edit-price_' + id);
                var updateButton = $('#btnUpdate_' + id);
                priceSpan.toggle();
                editPrice.toggle();
                updateButton.toggle();
            });
        });

        function updatePrice(id) {

            $("#btnUpdate_" + id).attr('disabled', 'disabled');
            var price_span = $("#med-price_" + id);
            var med_id = id;
            var new_Price = $('#edit-price_' + id).val();
            var newPriceValue = new_Price.trim();
            if (newPriceValue === '') {
                $('.alert-danger').html("Enter a price");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                $("#btnUpdate_" + id).removeAttr('disabled');
                return; // Stop execution
            }
            if (isNaN(newPriceValue) || parseFloat(newPriceValue) < 0) {
                $('.alert-danger').html("Please enter a positive number for the price");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                $("#btnUpdate_" + id).removeAttr('disabled');
                return; // Stop execution
            }

            $.ajax({
                type: "get",
                url: "{{ route('med.price.update') }}",
                data: {
                    med_id: med_id,
                    new_price: new_Price,
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    price_span.text(new_Price);
                    price_span.toggle();
                    $("#btnUpdate_" + id).removeAttr('disabled');
                    $("#btnUpdate_" + id).toggle();
                    $('#edit-price_' + id).toggle();
                }
            });


        }
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <form method="post">
                <div class="container">
                    <table class="table caption-top">
                        <caption>Depot Medications</caption>
                        <thead>
                            <tr class="table-warning">
                                <th>Name</th>
                                <th>Category</th>
                                <th>State</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="tbMeds" class="tbody">
                            @foreach ($medications as $medication)
                                <tr id="rowMed_{{ $medication->id }}">
                                    <td>
                                        {{ $medication->name }}
                                    </td>

                                    <td>
                                        {{ $medication->category }}
                                    </td>
                                    <td>
                                        {{ $medication->state }}
                                    </td>
                                    <td>
                                        <span class="med-price" id="med-price_{{ $medication->id }}">
                                            {{ $medication->pivot->price }}
                                        </span>
                                        <input type="number" class="price-input" id="edit-price_{{ $medication->id }}"
                                            value="{{ $medication->pivot->price }}" />
                                    </td>
                                    <td>
                                        {{ $medication->pivot->quantity }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn-custom btnEdit"
                                            data-id="{{ $medication->id }}">Edit</button>

                                        <button type="button" class="btn btn-primary btn-custom btnUpdate"
                                            onclick="updatePrice({{ $medication->id }})"
                                            id="btnUpdate_{{ $medication->id }}">update</button>
                                        <button type="button" class="btn-custom btnEdit"
                                            data-id="{{ $medication->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row justify-content-center mt-4">
                        {{ $medications->withQueryString()->links() }}
                    </div>
                </div>
            </form>

        </div>
    </div>
    <style>
        .container {
            margin-top: 170px;
            margin-left: auto;
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 880px;
            height: auto;
        }

        tbody tr:nth-child(odd) {
            background-color: #E5E5E5;
            /* Light gray background for odd rows */
        }

        tbody tr:nth-child(even) {
            background-color: #F2F2F2;
            /* Slightly darker gray background for even rows */
        }

        .tbody tr:hover {
            background-color: #cde5ff;
            /* A different background color on hover */
            color: #000;
            /* Change text color on hover, if desired */
            cursor: pointer;
            /* Change cursor to pointer on hover for a clickable feel */
        }

        .pagination li {
            margin: 0 5px;
        }

        caption {
            font-size: 24px;
            /* Adjust the font size as needed */
            font-weight: bold;
            margin-bottom: 10px;
            /* Optional: Add bold style to the caption */
        }

        .btn-custom {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 10px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
@endsection
