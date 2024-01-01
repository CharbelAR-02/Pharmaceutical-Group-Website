<?php

namespace App\Http\Controllers;

use App\Models\BaseDepot;
use App\Models\Medication;
use App\Models\Supplier;
use App\Models\SupplierCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;


class SupplierCommandsController extends Controller
{
    public function store(Request $request)
    {

        $supplierId = $request->input('supplier');
        $supplier = Supplier::find($supplierId);
        $command = new SupplierCommand();
        $command->supplier_id = $supplierId;
        if (auth()->user()->role === 'pharmacist') {
            $command->pharmacist_id = auth()->user()->pharmacist->id;
        }
        $command->save();


        foreach ($request->input('medications') as $index => $medicationId) {
            $newMedicationName = $request->input('new_medications.name')[$index] ?? null;
            $newMedicationCategory = $request->input('new_medications.category')[$index] ?? null;
            $newMedicationState = $request->input('new_medications.state')[$index] ?? null;
            $quantity = $request->input('quantities')[$index];



            if ($medicationId === null) {

                $existingMedication = Medication::where('name', $newMedicationName)
                    ->where('state', $newMedicationState)
                    ->where('category', $newMedicationCategory)
                    ->first();

                if ($existingMedication) {
                    $medication = $existingMedication;
                } else {
                    $medication = new Medication();
                    $medication->name = $newMedicationName;
                    $medication->state = $newMedicationState;
                    $medication->category = $newMedicationCategory;
                    $medication->save();
                }
                if (auth()->user()->role === 'special_employe') {
                    $basedepotitem = BaseDepot::where("medication_id", $medication->id)->first();
                    if (!$basedepotitem) {
                        // Create a new BaseDepot item if it doesn't exist
                        $basedepotitem = new BaseDepot();
                        $basedepotitem->medication_id = $medication->id;
                        $basedepotitem->save();
                    }
                } else {
                    $depot = auth()->user()->pharmacist->pharmacy->depot;
                    $medicationItem = $depot->medications()->wherePivot('medication_id', $medication->id)->first();


                    if (!$medicationItem) {
                        $depot->medications()->attach($medication->id, []);
                    }
                }
            } else {
                $medication = Medication::find($medicationId);
            }
            $command->medications()->attach($medication, ['quantity' => $quantity,]);
        }
        $pdfContent = Pdf::loadView('pdf.command-medications', ['medications' => $command->medications])->output();

        Mail::send([], [], function ($message) use ($supplier, $pdfContent) {
            $message->to($supplier->email)
                ->subject('Command Medications PDF')
                ->attachData($pdfContent, 'command_medications.pdf', [
                    'mime' => 'application/pdf',
                ]);
        });
        return redirect()->back()->with('success', 'Command created successfully.');
    }


    public function updateSupplier(Request $request)
    {
        $supplier_id = $request->input('id');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');

        $supplier = Supplier::find($supplier_id);
        $supplier->first_name = $first_name;
        $supplier->last_name = $last_name;
        $supplier->email = $email;
        $supplier->save();
        return response()->json(
            [
                'success' => 'Supplier has been updated',
            ]
        );
    }

    public function addSupplier(Request $request)
    {
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');

        $supplier  = new Supplier();
        $supplier->first_name = $first_name;
        $supplier->last_name = $last_name;
        $supplier->email = $email;
        $supplier->save();
        return response()->json([
            'success' => 'Supplier added successfully',
            'row' => '  <tr id="rowSupplier_' . $supplier->id . '">
            <td>
                <span class="first-name" id="first-name_' . $supplier->id . '">
                     ' . $supplier->first_name . '
                </span>
                <input type="text" class="edit-supplier" id="edit-first-name_' . $supplier->id . '"
                    value="' . $supplier->first_name . '" style="display: none;"/>
            </td>

            <td>
                <span class="last-name" id="last-name_' . $supplier->id . '">
                    ' . $supplier->last_name . '
                </span>
                <input type="text" class="edit-supplier" id="edit-last-name_' . $supplier->id . '"
                    value="' . $supplier->last_name . '" style="display: none;" />
            </td>
            <td>
                <span class="email" id="email_' . $supplier->id . '">
                    ' . $supplier->email . '
                </span>
                <input type="email" class="edit-supplier" id="edit-email_' . $supplier->id . '"
                    value="' . $supplier->email . '" style="display: none;" />
            </td>

            <td>
                <button type="button" class="btn btn-primary btnEdit"
                    data-id="' . $supplier->id . '">Edit</button>
                <button type="button" class="btn btn-primary"
                    onclick="deleteSupplier(' . $supplier->id . ')">Delete</button>
                <button type="button" class="btn btn-primary btnUpdate"
                    onclick="updateSupplier(' . $supplier->id . ')"
                    id="btnUpdate_' . $supplier->id . '" style="display: none;">update</button>
            </td>
        </tr>'
        ]);
    }

    public function deleteSupplier(Request $request)
    {
        $supplierID = $request->input('id');
        $supplier = Supplier::find($supplierID);
        $supplier->delete();
        return response()->json([
            'success' => 'Supplier deleted successfully',
        ]);
    }
}
