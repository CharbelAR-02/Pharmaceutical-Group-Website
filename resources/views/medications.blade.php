@extends('layout')
@section('header')
    <style>
        .container {
            margin-top: 130px;
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 1100px;
            height: 510px;
        }

        /* Style the search bar and criteria dropdown */
        .search-criteria {
            width: 38%;
            margin-bottom: 10px;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        /* Style the table */


        /* Style table headers */
        /* Style table header */


        /* Style table rows */
        tbody tr:nth-child(odd) {
            background-color: #E5E5E5;
            /* Light gray background for odd rows */
        }

        tbody tr:nth-child(even) {
            background-color: #F2F2F2;
            /* Slightly darker gray background for even rows */
        }

        /* Style pagination links */


        .pagination li {
            margin: 0 5px;
        }

        /* Add hover effect to table rows */
        .tbody tr:hover {
            background-color: #cde5ff;
            /* A different background color on hover */
            color: #000;
            /* Change text color on hover, if desired */
            cursor: pointer;
            /* Change cursor to pointer on hover for a clickable feel */
        }
    </style>
    <script>
        $(document).ready(function() {
            var originalTable = $('#medicamentsTable tbody').html();
            $('#searchInput').on('keyup', function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var term = $(this).val().trim();
                var searchCriteria = $('#searchCriteria').val();



                if (term === '') {
                    // If the search input is empty, restore the original table
                    $('#medicamentsTable tbody').html(originalTable);
                    console.log('table restored');
                } else {
                    // Perform the category filtering
                    $.ajax({
                        url: '{{ route('filter') }}',
                        method: 'post',
                        data: {
                            criteria: searchCriteria,
                            term: term
                        },
                        success: function(response) {
                            $('#medicamentsTable tbody').html(response);
                        }
                    });
                }
            });
        });
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mt-3">
                    <select id="searchCriteria" class="form-select search-criteria">
                        <option value="category">Search by category</option>
                        <option value="name">Search by Name</option>
                        <option value="state">Search by State</option>
                    </select>
                    <input type="search" name="" id="searchInput" class="form-control search-input"
                        placeholder="Search" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <table class="table" id="medicamentsTable">
                    <thead>
                        <tr class="table-warning">
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">State</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        @foreach ($medications as $medication)
                            <tr>
                                <td>{{ $medication->name }}</td>
                                <td>{{ $medication->category }}</td>
                                <td>{{ $medication->state }}</td>
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
@endsection
