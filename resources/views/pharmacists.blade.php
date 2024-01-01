@extends('layout')
@section('header')
    <script>
        $(document).ready(function() {

            $('.selectPharm').hide();
            $('.btnUpdate').hide(); // Hide inputs initially

            function attachEditButtonHandler(id) {
                var pharmselect = $('#PharmacyID_' + id);
                var pharmspan = $('#PharmSpan_' + id);
                var updateButton = $('#updatePharmacist_' + id);

                // Toggle visibility of spans and inputs
                pharmselect.toggle();
                pharmspan.toggle();
                updateButton.toggle();
            }

            $(document).on('click', '.btnEdit', function() {
                var id = $(this).data('id');
                attachEditButtonHandler(id);
            });

            $("#btnAdd_-1").click(function() {



                $(this).attr('disabled', 'disabled');


                $.ajax({
                    url: "{{ route('pharmacist.add') }}",
                    type: "get",
                    data: {
                        fname: $("#txtFirstName_-1").val(),
                        lname: $("#txtLastName_-1").val(),
                        email: $("#txtEmail_-1").val(),
                        pass: $('#txtPass_-1').val(),
                        pharm: $('#pharmacy_id').val()
                    },
                    success: function(output) {
                        if (output.error) {
                            $('.alert-danger').html(output.error);
                            $('.alert-danger').fadeIn().delay(2000).fadeOut();
                            // Display the validation errors to the user
                            $.each(output.errors, function(field, errors) {
                                // Append each error message to the corresponding form field
                                $('#' + field + '-error').text(errors[0]);
                            });
                            $("#btnAdd_-1").removeAttr('disabled');
                        } else {
                            $('.alert-success').html(output.success);
                            $('.alert-success').fadeIn().delay(2000).fadeOut();
                            setTimeout(function() {
                                location.reload();

                            }, 3000);
                            $("#tbPharmacists").append(output.row);
                            $("#btnAdd_-1").removeAttr('disabled');
                            $("#txtFirstName_-1").val("");
                            $("#txtLastName_-1").val("");
                            $("#txtEmail_-1").val("");
                            $("#txtPass_-1").val("");

                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function deletePharmacist(id) {
            $("#deletePharmacist_" + id).attr('disabled', 'disabled');
            $.ajax({
                url: "{{ route('pharmacist.delete') }}",
                type: "get",
                data: {
                    id: id
                },
                success: function(output) {
                    $('.alert-success').html(output.success);
                    $('.alert-success').fadeIn().delay(2000).fadeOut();
                    $("#rowPharmacist_" + id).fadeOut('slow', function() {
                        $(this).remove();
                        return false;
                    });
                    //$("#btnDelete_"+id).removeAttr('disabled');
                }
            });
        }

        function updatePharmacist(id) {
            $("#updatePharmacist_" + id).attr('disabled', 'disabled');
            var pharmspan = $('#PharmSpan_' + id);
            var pharmselect = $('#PharmacyID_' + id);
            var selectValue = $('#PharmacyID_' + id + ' option:selected').text();
            var updateButton = $('#updatePharmacist_' + id);
            $.ajax({
                url: "{{ route('pharmacist.update') }}",
                type: "get",
                data: {
                    id: id,
                    pharm_id: $("#PharmacyID_" + id).val()
                },
                success: function(output) {
                    $('.alert-success').html(output.success);
                    $('.alert-success').fadeIn().delay(2000).fadeOut();
                    pharmspan.text(selectValue);
                    pharmspan.toggle();
                    pharmselect.toggle();
                    updateButton.toggle();

                    $("#updatePharmacist_" + id).removeAttr('disabled');
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
    <?php $spId = $user->id; ?>
    <div class="container-fluid">
        <div class="row">
            <form class="" method="post">
                <div class="container">
                    <table class="table caption-top">
                        <caption>Pharmacists</caption>
                        <thead>
                            <tr class="table-warning">
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Pharmacy</th>
                                <th colspan=2>Action</th>
                            </tr>
                        </thead>

                        <tbody id="tbPharmacists">
                            @foreach ($pharmacists as $p)
                                <tr id="rowPharmacist_{{ $p->id }}">
                                    <td>{{ $p->user->first_name }}</td>

                                    <td>{{ $p->user->last_name }}</td>

                                    <td>{{ $p->user->email }}</td>



                                    <td>
                                        @if ($p->pharmacy->name ?? null)
                                            <span class="pharm-loc" id="PharmSpan_{{ $p->id }}">
                                                {{ $p->pharmacy->name }}
                                            </span>
                                            <select name="PharmacyID_{{ $p->id }}"
                                                id="PharmacyID_{{ $p->id }}" class="selectPharm">
                                                @foreach ($pharmacies as $pharmacy)
                                                    @if ($pharmacy->id == $p->pharmacy->id)
                                                        {
                                                        <option value="{{ $pharmacy->id }}" selected>{{ $pharmacy->name }}
                                                        </option>}
                                                    @else{<option value="{{ $pharmacy->id }}">{{ $pharmacy->name }}
                                                        </option>}
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <span class="pharm-loc" id="PharmSpan_{{ $p->id }}">
                                                not integrated
                                            </span>
                                            <select name="PharmacyID_{{ $p->id }}"
                                                id="PharmacyID_{{ $p->id }}" class="selectPharm">
                                                @foreach ($pharmacies as $pharmacy)
                                                    <option value="{{ $pharmacy->id }}">{{ $pharmacy->name }} </option>
                                                @endforeach
                                            </select>
                                        @endif

                                    </td>

                                    <td colspan=2>
                                        <button type="button" class="btn btn-primary btnEdit"
                                            data-id="{{ $p->id }}">Edit</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="deletePharmacist({{ $p->id }})"
                                            id="deletePharmacist_{{ $p->id }}">delete</button>
                                        <button type="button" class="btn btn-primary btnUpdate"
                                            onclick="updatePharmacist({{ $p->id }})"
                                            id="updatePharmacist_{{ $p->id }}">update</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tr>
                            <td colspan="6">New Pharmacist</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <input type="text" name="txtFirstName_-1" id="txtFirstName_-1"
                                        placeholder="enter first name" class="form-control" value="">
                                    <span id="fname-error" class="text-danger"></span>
                            </td>

                            <td><input type="text" name="txtLastName_-1" id="txtLastName_-1"
                                    placeholder="enter last name" class="form-control" value="">
                                <span id="lname-error" class="text-danger"></span>
                            </td>
                            <td><input type="email" name="txtEmail_-1" id="txtEmail_-1" placeholder="enter email"
                                    class="form-control" value="">
                                <span id="email-error" class="text-danger"></span>
                            </td>
                            <td><input type="password" name="txtPass_-1" id="txtPass_-1" placeholder="enter password"
                                    class="form-control" value="">
                                <span id="pass-error" class="text-danger"></span>
                            </td>
                            <td><select name="pharmacy_id" id="pharmacy_id" class="form-control">
                                    @foreach ($pharmacies as $pharmacy)
                                        <option value="{{ $pharmacy->id }}">{{ $pharmacy->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-primary" id="btnAdd_-1">add</button></td>
                        </tr>
                </div>

                </table>
                <div class="row justify-content-center mt-4">
                    {{ $pharmacists->withQueryString()->links() }}
                </div>
        </div>
        </form>
        <style>
            .container {
                margin-top: 125px;
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

            tbody tr:hover {
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
                /* Optional: Add bold style to the caption */
                margin-bottom: 10px;
            }

            .btn-primary:hover {
                background-color: #0056b3;
                /* Darker blue background color on hover */
            }
        </style>
    @endsection
