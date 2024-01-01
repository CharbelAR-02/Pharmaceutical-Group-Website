<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Models\Pharmacy;
use App\Models\SupplierCommand;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PharmacistController extends Controller
{
    public function addPharmacist(Request $request)
    {

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users,email',
            'pass' => 'required|min:8',
            'pharm' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return the validation errors as JSON response with status code 422 (Unprocessable Entity)
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        // Create a new user
        $user = new User();
        $user->first_name = $request->input('fname');
        $user->last_name = $request->input('lname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('pass'));
        $user->role = 'pharmacist';
        $user->save();

        // Create a new pharmacist
        $pharmacist = new Pharmacist();
        $pharmacist->user_id = $user->id;
        $pharmacist->pharmacy_id = $request->input('pharm');
        $pharmacist->save();

        $pharmacies = Pharmacy::all();
        $selectOptions = '';
        foreach ($pharmacies as $pharmacy) {
            $isSelected = $pharmacy->id == $pharmacist->pharmacy->id ? 'selected' : '';
            $selectOptions .= '<option value="' . $pharmacy->id . '" ' . $isSelected . '>' . $pharmacy->name . '</option>';
        }

        // Return a success response
        return response()->json([
            'success' => 'Pharmacist added successfully',
            'row' => '<tr id="rowPharmacist_' . $pharmacist->id . '">
                   <td>' . $user->first_name . '</td>
                   <td>' . $user->last_name . '</td>
                   <td>' . $user->email . '</td>
                   <td>
                   <span class="pharm-loc" id="PharmSpan_' . $pharmacist->id . '">' .
                $pharmacist->pharmacy->name . '
                </span>
                    <select id="PharmacyID_' . $pharmacist->id . '" name="PharmacyID_' . $pharmacist->id . '" class="selectPharm"  style="display: none;">
                        ' . $selectOptions . '
                    </select>
                   </td>
                   <td colspan="2">
                       <button type="button" class="btn btn-primary btnEdit" data-id="' . $pharmacist->id . ' ">Edit</button>
                       <button type="button" class="btn btn-primary" onclick="deletePharmacist(' . $pharmacist->id . ')" id="deletePharmacist_' . $pharmacist->id . '">delete</button>
                       <button type="button" class="btn btn-primary" onclick="updatePharmacist(' . $pharmacist->id . ')" id="updatePharmacist_' . $pharmacist->id . '" style="display: none;">update</button>
                   </td>
               </tr>'
        ]);
    }

    public function deletePharmacist(Request $request)
    {
        $id = $request->input('id');

        // Find the pharmacist
        $pharmacist = Pharmacist::find($id);

        // Get the associated user
        $user = $pharmacist->user;

        $user->delete();

        return response()->json(['success' => 'Pharmacist deleted successfully']);
    }

    public function UpdatePharmacist(Request $request)
    {
        $pharmacist_id = $request->input('id');
        $pharmacy_id = $request->input('pharm_id');

        $Updated_pharmacist = Pharmacist::find($pharmacist_id);

        if (!$Updated_pharmacist) {
            return response()->json(['error' => 'Pharmacist not found'], 404);
        }

        $Updated_pharmacist->pharmacy_id = $pharmacy_id;
        $Updated_pharmacist->save();

        return response()->json(['success' => 'Pharmacist updated successfully']);
    }

    public function index($id)
    {
        $depot = auth()->user()->pharmacist->pharmacy->depot;
        $medications = $depot->medications()->paginate(4);
        return view('depot-medications', compact('medications'));
    }

    public function updatePrice(Request $request)
    {
        $med_id = $request->input('med_id');
        $new_price = $request->input('new_price');

        $depot = auth()->user()->pharmacist->pharmacy->depot;

        $depot->medications()->updateExistingPivot($med_id, ['price' => $new_price]);

        return response()->json([
            'success' => 'Price updated successfully',
        ]);
    }

    public function pharmacistSupplierCommandsShow($id)
    {
        $user = User::find($id);
        $pharmacist = $user->pharmacist;
        $commands = SupplierCommand::where('pharmacist_id', $pharmacist->id)->latest()->get();

        return view('pharmacist-supplier-commands', compact('commands', 'user'));
    }

    public function itemsarrived(Request $request)
    {
        $commandId = $request->input('commandId');

        $command = SupplierCommand::find($commandId);
        $command->arrived_at = Carbon::now();
        $command->status = 'arrived';
        $command->save();

        $formattedArrivedAt = $command->arrived_at->format('Y-m-d H:i:s');

        $commandMedications = $command->medications;


        $depot = auth()->user()->pharmacist->pharmacy->depot;


        foreach ($commandMedications as $commandMedication) {

            $medicationId = $commandMedication->pivot->medication_id;


            $depotMedication = DB::table('depot_medications')
                ->where('medication_id', $medicationId)
                ->where('depot_id', $depot->id)
                ->first();
            // Debugging output
            if ($depotMedication) {
                $depotMedication->quantity += $commandMedication->pivot->quantity;
                $depot->medications()->updateExistingPivot(
                    $medicationId,
                    ['quantity' =>   $depotMedication->quantity]
                );
            }
        }
        return response()->json([
            'success' => 'supplier items arrived successfully',
            'status' => 'arrived',
            'arrived_at' => $formattedArrivedAt,
        ]);
    }
}
