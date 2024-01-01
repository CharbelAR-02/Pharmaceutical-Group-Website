@extends('layout')
@section('header')
    <script>
        $(document).ready(function() {
            $('.edit-supplier').hide();
            $('.btnUpdate').hide();
        })

        $(document).on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            $('#edit-first-name_' + id).toggle();
            $('#edit-last-name_' + id).toggle();
            $('#edit-email_' + id).toggle();
            $('#btnUpdate_' + id).toggle();
            $('#first-name_' + id).toggle();
            $('#last-name_' + id).toggle();
            $('#email_' + id).toggle();

        });

        function updateSupplier(id) {
            $("#btnUpdate_" + id).attr('disabled', 'disabled');
            var new_first_name = $('#edit-first-name_' + id).val();
            var new_last_name = $('#edit-last-name_' + id).val();
            var new_email = $('#edit-email_' + id).val();

            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!new_first_name || !new_last_name || !new_email) {
                $('.alert-danger').html("Please fill in all fields");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                $("#btnUpdate_" + id).removeAttr('disabled');
                return; // Abort the update if any field is empty
            }

            if (!emailPattern.test(new_email)) {
                $('.alert-danger').html("Please enter a valid email address");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                $("#btnUpdate_" + id).removeAttr('disabled');
                return;
            }

            $.ajax({
                url: "{{ route('supplier.update') }}",
                type: "get",
                data: {
                    id: id,
                    first_name: new_first_name,
                    last_name: new_last_name,
                    email: new_email
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $('#first-name_' + id).text(new_first_name).toggle();
                    $('#last-name_' + id).text(new_last_name).toggle();
                    $('#email_' + id).text(new_email).toggle();
                    $('#edit-first-name_' + id).toggle();
                    $('#edit-last-name_' + id).toggle();
                    $('#edit-email_' + id).toggle();
                    $("#btnUpdate_" + id).removeAttr('disabled').toggle();

                },

                error: function(xhr, status, error) {
                    // Handle the error response here if needed
                    // For example, display an error message to the user
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).on('click', '#btnAdd', function() {
            console.log("hello");
            $(this).attr('disabled', 'disabled');

            var first_name = $('#txtfirstname').val();
            var last_name = $('#txtlastname').val();
            var email = $('#txtemail').val();

            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

            // Check for empty fields
            if (first_name.trim() === '' || last_name.trim() === '' || email.trim() === '') {
                $('.alert-danger').html("Please fill in all fields");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                // Re-enable the button
                $(this).removeAttr('disabled');
                return;
            }

            // Check email format
            if (!emailPattern.test(email)) {
                $('.alert-danger').html("Please enter a valid email address");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                $(this).removeAttr('disabled');
                return;
            }

            $.ajax({
                url: "{{ route('supplier.add') }}",
                type: "get",
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $("#tbSuppliers").append(output.row);
                    setTimeout(function() {
                        location.reload();

                    }, 3000);
                    $('#txtfirstname').val("");
                    $('#txtlastname').val("");
                    $('#txtemail').val("");
                    $('#btnAdd').removeAttr('disabled');
                }
            });

        });

        function deleteSupplier(id) {
            $("#btnDelete_" + id).attr('disabled', 'disabled');
            $.ajax({
                url: "{{ route('supplier.delete') }}",
                type: "get",
                data: {
                    id: id
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $("#rowSupplier_" + id).fadeOut('slow', function() {
                        $(this).remove();
                        return false;
                    });
                    //$("#btnDelete_"+id).removeAttr('disabled');
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
                        <caption>Suppliers</caption>
                        <thead>
                            <tr class="table-warning">
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="tbSuppliers" class="tbody">
                            @foreach ($suppliers as $supplier)
                                <tr id="rowSupplier_{{ $supplier->id }}">
                                    <td>
                                        <span class="first-name" id="first-name_{{ $supplier->id }}">
                                            {{ $supplier->first_name }}
                                        </span>
                                        <input type="text" class="edit-supplier" id="edit-first-name_{{ $supplier->id }}"
                                            value="{{ $supplier->first_name }}" />
                                    </td>

                                    <td>
                                        <span class="last-name" id="last-name_{{ $supplier->id }}">
                                            {{ $supplier->last_name }}
                                        </span>
                                        <input type="text" class="edit-supplier" id="edit-last-name_{{ $supplier->id }}"
                                            value="{{ $supplier->last_name }}" />
                                    </td>
                                    <td>
                                        <span class="email" id="email_{{ $supplier->id }}">
                                            {{ $supplier->email }}
                                        </span>
                                        <input type="email" class="edit-supplier" id="edit-email_{{ $supplier->id }}"
                                            value="{{ $supplier->email }}" />
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-primary btnEdit"
                                            data-id="{{ $supplier->id }}">Edit</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="deleteSupplier({{ $supplier->id }})">Delete</button>
                                        <button type="button" class="btn btn-primary btnUpdate"
                                            onclick="updateSupplier({{ $supplier->id }})"
                                            id="btnUpdate_{{ $supplier->id }}">update</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>



                        <tr>
                            <td colspan="4">New Supplier</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="txtfirstname" placeholder="enter first name" class="form-control"
                                    value="">

                            </td>
                            <td><input type="text" id="txtlastname" placeholder="enter last name" class="form-control"
                                    value=""></td>
                            <td><input type="email" id="txtemail" placeholder="enter email" class="form-control"
                                    value=""></td>
                            <td><button type="button" class="btn btn-primary" id="btnAdd">add</button></td>
                        </tr>

                    </table>
                    <div class="row justify-content-center mt-4">
                        {{ $suppliers->withQueryString()->links() }}
                    </div>
                </div>
            </form>

        </div>
    </div>
    <style>
        .container {
            margin-top: 130px;
            margin-left: auto;
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: auto;
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
