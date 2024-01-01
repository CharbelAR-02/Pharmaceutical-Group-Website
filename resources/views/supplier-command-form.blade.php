@extends('layout')
@section('header')
    <script>
        $(document).ready(function() {

            $('#myForm').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Validate form fields here
                var isValid = true;

                // Example validation for the supplier field
                var supplier = $('#supplierSelect').val();
                if (!supplier) {
                    isValid = false;
                    //  $('#supplierError').text('Please select a supplier');
                    alert('enter supplier');
                }

                // Add more validation for other fields as needed

                // If validation fails, do not submit the form
                if (!isValid) {
                    return false;
                }

                // If validation passes, submit the form
                this.submit();
            });

            $(document).on('change', '.medicationSelect', function() {

                var select = $(this);
                var input = select.closest('.medication-entry').find('.newMedication');

                // Check if a medication is selected
                if (select.val() !== '') {
                    // If selected, disable the new medication input and clear its value
                    input.hide().val('');
                    input.prop('required', false);
                } else {
                    // If not selected, enable the new medication input
                    input.show();

                    input.prop('required', true);

                }
            });

            $('#add-medication').click(function() {
                var clonedEntry = $('.medication-entry:first').clone();
                clonedEntry.find('select, input[type="text"], input[type="number"]').val('');
                clonedEntry.find('input[type="text"], input[type="number"]').attr('required', 'required');
                clonedEntry.find('.newMedication').show();
                clonedEntry.append(
                    '<button type="button" class="btn btn-danger remove-medication">Remove Medication</button>'
                );
                $('#medications-container').append(clonedEntry);
            });

            $(document).on('click', '.remove-medication', function() {
                $(this).closest('.medication-entry').remove();
            });
        });
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <form id="myForm" method="POST" action="{{ route('suppler.command.store') }}">
                    @csrf
                    <div class="form-group select-supp">
                        <select class="form-control small-input" name="supplier" id="supplierSelect">
                            <option value="" selected> Select a Supplier
                            </option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->first_name }}
                                    {{ $supplier->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier')
                            <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="medications-container">
                        <div class="medication-entry">
                            <div class="form-group">
                                <label for="medication" class="input-margin">Select or Add New Medication:</label>
                                <select class="form-control medicationSelect  input-margin" name="medications[]">
                                    <option value="" selected>Select Medication</option>
                                    @foreach ($medications as $medication)
                                        @if (Auth::user()->role === 'special_employe')
                                            <option value="{{ $medication->medication->id }}">
                                                {{ $medication->medication->name }}</option>
                                        @else
                                            <option value="{{ $medication->id }}">
                                                {{ $medication->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group input-margin">
                                <label for="new_medication_name" class="newMedication input-margin">New Medication:
                                </label>
                                <input type="text" class="form-control newMedication" name="new_medications[name][]"
                                    placeholder="enter name" required>

                            </div>
                            <div class="form-group input-margin">
                                <input type="text" class="form-control newMedication" name="new_medications[category][]"
                                    placeholder="enter Category" required>

                            </div>
                            <div class="form-group input-margin">
                                <input type="text" class="form-control newMedication" name="new_medications[state][]"
                                    placeholder="enter State" required>

                            </div>
                            <div class="form-group input-margin">
                                <input type="number" class="form-control" name="quantities[]" min="1"
                                    placeholder="enter quantity" required>

                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-medication" class="btn btn-secondary">Add Medication</button>
                    <button type="submit" class="btn btn-primary">Create Command</button>
                </form>
            </div>
            <style>
                .medication-entry {
                    background-color: #f7f7f7;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    margin-bottom: 20px;
                    width: 380px;
                }

                .container {
                    margin-top: 100px;

                }

                .select-supp {
                    margin-bottom: 20px;
                }

                .small-input {
                    width: 300px;

                }

                .input-margin {
                    margin-bottom: 10px;
                    /* Adjust the margin as needed */
                }
            </style>
        @endsection
