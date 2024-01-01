@extends('layout')
@section('content')
    <?php $spId = $user->id; ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->

            <div class="container">
                <table class="table caption-top">
                    <caption>Special Employes</caption>
                    <thead>
                        <tr class="table-warning">
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        @foreach ($specialEmps as $se)
                            <tr>
                                <td>{{ $se->user->first_name }}</td>
                                <td>{{ $se->user->last_name }}</td>
                                <td>{{ $se->user->email }}</td>
                        @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-center mt-4">
                    {{ $specialEmps->withQueryString()->links() }}
                </div>
            </div>
            <style>
                .container {
                    margin-top: 175px;
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
            </style>
        @endsection
