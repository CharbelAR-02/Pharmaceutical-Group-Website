@extends('layout')
@section('header')
    <script>
        function deleteCustomer(id) {
            $("#deleteCustomer_" + id).attr('disabled', 'disabled');
            $.ajax({
                url: "{{ route('customer.delete') }}",
                type: "get",
                data: {
                    id: id
                },
                success: function(output) {
                    $('#live-alert').html(output.success);
                    $('#live-alert').fadeIn().delay(2000).fadeOut();
                    $("#rowCustomer_" + id).fadeOut('slow', function() {
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
    <?php $spId = $user->id; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <table class="table caption-top">
                    <caption>Customers</caption>
                    <thead>
                        <tr class="table-warning">
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbCustomers" class="tbody">
                        @foreach ($customers as $c)
                            <tr id="rowCustomer_{{ $c->id }}">
                                <td>{{ $c->user->first_name }}</td>
                                <td>{{ $c->user->last_name }}</td>
                                <td>{{ $c->user->email }}</td>
                                <td><button type="button" class="btn btn-primary"
                                        onclick="deleteCustomer({{ $c->id }})"
                                        id="deleteCustomer_{{ $c->id }}">delete</button></td>
                        @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-center mt-4">
                    {{ $customers->withQueryString()->links() }}
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
                    /* Optional: Add bold style to the caption */
                    margin-bottom: 10px;
                }

                .btn-primary:hover {
                    background-color: #0056b3;
                    /* Darker blue background color on hover */
                }
            </style>
        @endsection
