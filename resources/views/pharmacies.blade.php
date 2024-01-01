@extends('layout')
@section('header')
    <script>
        $(document).ready(function() {
            $('.pharm-input').hide();
            $('.btnUpdate').hide(); // Hide inputs initially

            function attachEditButtonHandler(id) {
                var pharmNameSpan = $('#Pharm_name_' + id);
                var pharmLocSpan = $('#Pharm_loc_' + id);
                var editPharmNameInput = $('#Edit_Pharm_name_' + id);
                var editPharmLocInput = $('#Edit_Pharm_loc_' + id);
                var updateButton = $('#btnUpdate_' + id);

                // Toggle visibility of spans and inputs
                pharmNameSpan.toggle();
                pharmLocSpan.toggle();
                editPharmNameInput.toggle();
                editPharmLocInput.toggle();
                updateButton.toggle();
            }

            $(document).on('click', '.btnEdit', function() {
                var id = $(this).data('id');
                attachEditButtonHandler(id);
            });

            // Rest of your delete function and other code...
        });

        $(document).on('click', '#btnAdd', function() {
            $(this).attr('disabled', 'disabled');

            var name = $("#txtName_0").val();
            var location = $("#txtLocation_0").val();

            if (!name || !location) {
                $('.alert-danger').html("Please fill in all fields");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                $(this).removeAttr('disabled');
                return; // Abort the update if any field is empty
            }


            $.ajax({
                url: "{{ route('pharmacy.add') }}",
                type: "get",
                data: {
                    name: $("#txtName_0").val(),
                    location: $("#txtLocation_0").val()
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $("#tbPharmacies").append(output.row);
                    setTimeout(function() {
                        console.log('reloading');
                        window.location.reload();

                    }, 3000);
                    $("#btnAdd").removeAttr('disabled');
                    $("#txtName_0").val("");
                    $("#txtLocation_0").val("");

                }
            });
        });

        function deletePharmacy(id) {
            $("#btnDelete_" + id).attr('disabled', 'disabled');
            $.ajax({
                url: "{{ route('pharmacy.delete') }}",
                type: "get",
                data: {
                    id: id
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $("#rowPharmacy_" + id).fadeOut('slow', function() {
                        $(this).remove();
                        return false;
                    });
                    //$("#btnDelete_"+id).removeAttr('disabled');
                }
            });
        }


        function updatePharmacy(id) {
            $("#btnUpdate_" + id).attr('disabled', 'disabled');
            var pharmNameSpan = $('#Pharm_name_' + id);
            var pharmLocSpan = $('#Pharm_loc_' + id);
            var pharmLocEdit = $("#Edit_Pharm_name_" + id).val();
            var pharmNameEdit = $("#Edit_Pharm_loc_" + id).val();

            if (!pharmLocEdit || !pharmNameEdit) {
                $('.alert-danger').html("Please fill in all fields");
                $('.alert-danger').fadeIn().delay(2000).fadeOut();
                $("#btnUpdate_" + id).removeAttr('disabled');
                return; // Abort the update if any field is empty
            }

            $.ajax({
                url: "{{ route('pharmacy.update') }}",
                type: "get",
                data: {
                    id: id,
                    name: $("#Edit_Pharm_name_" + id).val(),
                    loc: $("#Edit_Pharm_loc_" + id).val(),
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $("#btnUpdate_" + id).removeAttr('disabled');
                    pharmNameSpan.text($("#Edit_Pharm_name_" + id).val());
                    pharmLocSpan.text($("#Edit_Pharm_loc_" + id).val());
                    pharmNameSpan.toggle();
                    pharmLocSpan.toggle();
                    $("#Edit_Pharm_name_" + id).toggle();
                    $("#Edit_Pharm_loc_" + id).toggle();
                    $("#btnUpdate_" + id).toggle();
                },

                error: function(xhr, status, error) {
                    // Handle the error response here if needed
                    // For example, display an error message to the user
                    console.error(xhr.responseText);
                }
            });

        }




        function accessDepot(id) {
            $("#btnAccess_" + id).attr('disabled', 'disabled');
            $.ajax({
                url: "{{ url('/special-emp/pharmacies/depotShow') }}",
                type: "get",
                data: {
                    id: id
                },
                success: function(output) {
                    $('.alert').show();
                    $('.alert').html(output.success);
                    $("#showmeds").html(output.table);
                    $("#btnAccess_" + id).removeAttr('disabled');
                },

                error: function(xhr, status, error) {
                    // Handle the error response here if needed
                    // For example, display an error message to the user
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    <style>
        @media (min-width: 768px) {
            .container {
                margin-left: 0;
                padding-left: 0;
            }
        }
    </style>
@endsection
@section('content')
    <?php $spId = $user->id; ?>
    <div class="container-fluid">
        <div class="row">
            <form method="post">
                <div class="container">
                    <table class="table caption-top">
                        <caption>Pharmacies</caption>
                        <thead>
                            <tr class="table-warning">
                                <th>Name</th>
                                <th>Location</th>
                                <th>action</th>
                            </tr>
                        </thead>

                        <tbody id="tbPharmacies" class="tbody">
                            @foreach ($pharmacies as $ph)
                                <tr id="rowPharmacy_{{ $ph->id }}">
                                    <td>
                                        <span class="pharm-name" id="Pharm_name_{{ $ph->id }}">
                                            {{ $ph->name }}
                                        </span>
                                        <input type="text" class="pharm-input" id="Edit_Pharm_name_{{ $ph->id }}"
                                            value="{{ $ph->name }}" />
                                    </td>

                                    <td>
                                        <span class="pharm-loc" id="Pharm_loc_{{ $ph->id }}">
                                            {{ $ph->location }}
                                        </span>
                                        <input type="text" class="pharm-input" id="Edit_Pharm_loc_{{ $ph->id }}"
                                            value="{{ $ph->location }}" />
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-primary btnEdit"
                                            data-id="{{ $ph->id }}">Edit</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="deletePharmacy({{ $ph->id }})">Delete</button>
                                        <button type="button" class="btn btn-primary btnUpdate"
                                            onclick="updatePharmacy({{ $ph->id }})"
                                            id="btnUpdate_{{ $ph->id }}">update</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>



                        <tr>
                            <td colspan="3">New Pharmacy</td>
                        </tr>
                        <tr>
                            <td>

                                <input type="text" name="txtName_0" id="txtName_0" placeholder="enter name"
                                    class="form-control" value="">

                            </td>
                            <td><input type="text" name="txtLocation_0" id="txtLocation_0" placeholder="enter location"
                                    class="form-control" value=""></td>
                            <td><button type="button" class="btn btn-primary" id="btnAdd">add</button></td>
                        </tr>

                    </table>
                    <div class="row justify-content-center mt-4">
                        {{ $pharmacies->withQueryString()->links() }}
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

        .btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue background color on hover */
        }
    </style>
@endsection
