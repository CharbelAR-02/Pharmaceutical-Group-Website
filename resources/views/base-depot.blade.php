@extends('layout')
@section('header')
    <script>
        $(document).ready(function() {
            price_input = $('.price-input').hide();
            edit_button = $('.btnUpdate').hide();

            // Specify the threshold quantity for highlighting
            var threshold = 50;

            // Loop through each medication row and check the quantity
            $('#tbMedications tr').each(function() {
                var quantityCell = $(this).find('td:eq(4)'); // Index 4 is the Quantity column

                // Parse the quantity value
                var quantity = parseInt(quantityCell.text());

                // Apply red color if quantity is below the threshold
                if (quantity < threshold) {
                    quantityCell.css('color', 'red');
                }
            });

        });

        $(document).on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            $('#btnUpdate_' + id).toggle();
            $('#Edit_med_price_' + id).toggle();
            $('#med_price_' + id).toggle();
        });


        function updateBaseDepotItem(id) {
            $("#btnUpdate_" + id).attr('disabled', 'disabled');
            var med_price = $('#Edit_med_price_' + id).val();
            if (isNaN(med_price) || med_price <= 0) {
                $('.alert-danger').html("Please enter a valid positive number for the medication price.");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                $("#btnUpdate_" + id).removeAttr('disabled');
                return; // Abort the update if any field is empty
            }
            $.ajax({
                url: "{{ route('baseDepot.item.update') }}",
                type: "get",
                data: {
                    id: id,
                    med_price: med_price,
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $("#btnUpdate_" + id).removeAttr('disabled');
                    $("#med_price_" + id).text($("#Edit_med_price_" + id).val());
                    $("#Edit_med_price_" + id).toggle();
                    $("#med_price_" + id).toggle();
                    $("#btnUpdate_" + id).toggle();
                },

                error: function(xhr, status, error) {
                    // Handle the error response here if needed
                    // For example, display an error message to the user
                    console.error(xhr.responseText);
                }
            });

        }

        function deleteBaseDepotItem(id) {
            $("#btnDelete_" + id).attr('disabled', 'disabled');
            $.ajax({
                url: "{{ route('baseDepot.item.delete') }}",
                type: "get",
                data: {
                    id: id,
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $("#rowMedication_" + id).fadeOut('slow', function() {
                        $(this).remove();
                        return false;
                    });
                },

                error: function(xhr, status, error) {
                    // Handle the error response here if needed
                    // For example, display an error message to the user
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <table class="table caption-top">
                    <caption>medications</caption>
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
                    <tbody id="tbMedications" class="tbody">
                        @foreach ($medications as $medication)
                            <tr id="rowMedication_{{ $medication->id }}">
                                <td>{{ $medication->medication->name }}</td>
                                <td>{{ $medication->medication->category }}</td>
                                <td>{{ $medication->medication->state }}</td>
                                @if ($medication->price ?? null)
                                    <td><span id="med_price_{{ $medication->id }}">{{ $medication->price }}</span>
                                        <input type="text" class="price-input" id="Edit_med_price_{{ $medication->id }}"
                                            value="{{ $medication->price }}" />
                                    </td>
                                @else
                                    <td><span id="med_price_{{ $medication->id }}"><strong>undefined</strong></span>
                                        <input type="text" class="price-input" id="Edit_med_price_{{ $medication->id }}"
                                            value="" />
                                    </td>
                                @endif


                                <td>{{ $medication->quantity }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btnEdit"
                                        data-id="{{ $medication->id }}">Edit</button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="deleteBaseDepotItem({{ $medication->id }})"
                                        id="btnDelete_{{ $medication->id }}">Delete</button>
                                    <button type="button" class="btn btn-primary btnUpdate"
                                        onclick="updateBaseDepotItem({{ $medication->id }})"
                                        id="btnUpdate_{{ $medication->id }}">update</button>
                                </td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-center mt-4">
                    {{ $medications->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    <style>
        .container {
            margin-top: 165px;
            margin-left: auto;
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 1000px;
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

        .btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue background color on hover */
        }
    </style>
@endsection
