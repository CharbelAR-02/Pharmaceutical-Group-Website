@extends('layout')
@section('header')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addtocart(id) {
            const quantityInput = document.getElementById(`quantity_${id}`);
            const min = parseInt(quantityInput.min);
            const max = parseInt(quantityInput.max);
            const value = parseInt(quantityInput.value);
            if (isNaN(value) || value < min || value > max) {
                quantityInput.value = '';
                // Display an error message to the user or handle the invalid input as needed
                $('.alert-danger').html("Invalid Quantity");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                return; // Do not proceed with the AJAX request
            }

            var quantity = $('#quantity_' + id).val();
            var medicament_id = $('#quantity_' + id).attr('data-medication-id');
            var medicament_price = $('#quantity_' + id).attr('data-medication-price');
            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: {
                    quantity: quantity,
                    id: id,
                    user_id: "{{ $user->id }}",
                    med_id: medicament_id,
                    med_price: medicament_price,
                },
                success: function(response) {
                    $('.alert-success').html(response.success);
                    $('.alert-success').fadeIn().delay(2000).fadeOut();
                },

                error: function(xhr) {
                    console.log('Error: ' + xhr.responseText);
                }
            });
        }
    </script>
@endsection
@section('content')
    <div class="container">
        <table class="table caption-top">
            <caption>Shop</caption>
            <thead>
                <tr class="table-warning">
                    <th>Name</th>
                    <th>Category</th>
                    <th>Unit_price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medications as $med)
                    <tr>
                        <td>{{ $med->medication->name }}</td>
                        <td>{{ $med->medication->category }}</td>
                        <td>{{ $med->price }}</td>
                        <td>
                            @if ($med->quantity > 0)
                                <input type="number" id="quantity_{{ $med->id }}" class="quantity-input"
                                    name="quantity_{{ $med->id }}" min="1" max="{{ $med->quantity }}"
                                    data-medication-id="{{ $med->medication->id }}"
                                    data-medication-price="{{ $med->price }}" />
                            @else
                                <span class="text-danger">Out of Stock</span>
                            @endif
                        </td>

                        <td>
                            @if ($med->quantity > 0)
                                <button type="button" class="btn btn-primary" name="btnAdd_{{ $med->id }}"
                                    onclick="addtocart({{ $med->id }})" id="btnAdd_{{ $med->id }}">add to
                                    cart</button>
                            @else
                                <button type="button" class="btn btn-secondary btn-secondary-out-of-stock" disabled>Out of
                                    Stock</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row justify-content-center mt-4">
            {{ $medications->withQueryString()->links() }}
        </div>
    </div>
    <div id="invoiceDiv"></div>
    <style>
        .pagination li {
            margin: 0 5px;
        }

        /* Style the table headers */


        /* Style table rows */
        tbody tr:nth-child(odd) {
            background-color: #E5E5E5;
            /* Light gray background for odd rows */
        }

        tbody tr:nth-child(even) {
            background-color: #F2F2F2;
            /* Slightly darker gray background for even rows */
        }

        tbody tr:hover {
            background-color: #cde5ff;
            /* A different background color on hover */
            color: #000;
            /* Change text color on hover, if desired */
            cursor: pointer;
            /* Change cursor to pointer on hover for a clickable feel */
        }

        /* Style the quantity input field */
        .quantity-input {
            width: 60px;
            /* Adjust the width as needed */
            text-align: center;
            /* Center the text inside the input */
            background-color: #fff;
            /* White background for input */
            border: 1px solid #ccc;
            /* Gray border for input */
            border-radius: 5px;
            /* Rounded corners for input */
        }

        /* Style the "Add to Cart" button */
        .btn-primary {
            background-color: #007BFF;
            /* Blue background color for the button */
            color: #fff;
            /* White text color for the button */
            border: none;
            /* Remove button border */
            border-radius: 5px;
            /* Rounded corners for the button */
            padding: 5px 10px;
            /* Adjust padding as needed */
        }

        /* Style the "Add to Cart" button on hover */
        .btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue background color on hover */
        }

        .container {
            margin-top: 170px;
            margin-left: auto;
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: auto;
            height: auto;
        }

        /*#f2f2f2;*/

        caption {
            font-size: 24px;
            /* Adjust the font size as needed */
            font-weight: bold;
            margin-bottom: 10px;
            /* Optional: Add bold style to the caption */
        }

        .btn-secondary-out-of-stock {
            background-color: #ccc;
            /* Change the background color */
            color: #fff;
            /* Change the text color */
            border-color: #ccc;
            /* Change the border color */
            cursor: not-allowed;
            /* Change the cursor to indicate it's not clickable */
        }

        .btn-secondary-out-of-stock:hover {
            background-color: #ccc;
            /* Change the background color on hover */
            color: #fff;
            /* Change the text color on hover */
            border-color: #ccc;
            cursor: not-allowed;
            /* Change the border color on hover */
        }
    </style>
@endsection
