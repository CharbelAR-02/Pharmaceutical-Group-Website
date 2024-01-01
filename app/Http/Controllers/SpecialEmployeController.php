<?php

namespace App\Http\Controllers;

use App\Models\BaseDepot;
use App\Models\Command;
use App\Models\Customer;
use App\Models\Pharmacist;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\SpecialEmploye;
use App\Models\Supplier;
use App\Models\SupplierCommand;
use App\Models\User;
use Carbon\Carbon;

class SpecialEmployeController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        $users = User::all();
        $pharmacies = Pharmacy::all();
        $pharmacists = Pharmacist::all();
        $customers = Customer::all();
        $specialEmps = SpecialEmploye::all();
        $medications = BaseDepot::all();

        return view('special-emp-home', compact('user', 'users', 'pharmacies', 'pharmacists', 'customers', 'specialEmps', 'medications'));
    }

    public function pharmacies($id)
    {
        $user = User::find($id);
        $pharmacies = Pharmacy::paginate(4);
        return view('pharmacies', compact('pharmacies', 'user'));
    }


    public function pharmacists($id)
    {
        $user = User::find($id);
        $pharmacists = Pharmacist::paginate(4);
        $pharmacies = Pharmacy::all();
        return view('pharmacists', compact('pharmacists', 'user', 'pharmacies'));
    }

    public function customers($id)
    {
        $user = User::find($id);
        $customers = Customer::paginate(4);
        return view('customers', compact('customers', 'user'));
    }

    public function specialEmployes($id)
    {
        $user = User::find($id);
        $specialEmps = SpecialEmploye::paginate(4);
        return view('specialEmps', compact('user', 'specialEmps'));
    }

    public function commands($id)
    {
        $user = User::find($id);
        $commands = Command::orderBy('created_at', 'desc')->get();
        return view('commands', compact('user', 'commands'));
    }

    public function itemsShip(Request $request)
    {
        $commandId = $request->input('commandId');
        $command = Command::where('id', $commandId)->first();
        $command->status = "shipped";
        $command->shipped_at = Carbon::now();
        $command->save();

        $commandMedications = $command->medications()->get();

        foreach ($commandMedications as $commandMedication) {
            $baseDepotItem = BaseDepot::where('medication_id', $commandMedication->pivot->medication_id)->first();
            $baseDepotItem->quantity = $baseDepotItem->quantity - $commandMedication->pivot->quantity;
            $baseDepotItem->save();
        }
        $formattedShippedAt = $command->shipped_at->format('Y-m-d H:i:s');

        return response()->json([
            'success' => 'items shipped successfully',
            'status' => $command->status,
            'shipped_at' => $formattedShippedAt,
        ]);
    }

    public function supplierCommandFormShow($id)
    {
        $user = User::find($id);
        if ($user->role === 'pharmacist') {
            $medications = $user->pharmacist->pharmacy->depot->medications;
        } else {
            $medications = BaseDepot::all();
        }
        $suppliers = Supplier::all();
        return view('supplier-command-form', compact('medications', 'user', 'suppliers'));
    }

    public function suppliers($id)
    {
        $user = User::find($id);
        $suppliers = Supplier::paginate(4);
        return view('suppliers', compact('suppliers'));
    }

    public function basedepotshow($id)
    {
        $user = User::find($id);
        $medications = BaseDepot::paginate(4);
        return view('base-depot', compact('medications', 'user'));
    }

    public function supplierCommandsShow($id)
    {
        $user = User::find($id);
        $commands = SupplierCommand::whereNull('pharmacist_id')->latest()->get();
        return view('supplier-commands', compact('user', 'commands'));
    }

    public function itemsArrived(Request $request)
    {
        $commandId = $request->input('commandId');
        $command = SupplierCommand::find($commandId);
        $command->arrived_at = Carbon::now();
        $command->status = 'arrived';
        $command->save();

        $formattedArrivedAt = $command->arrived_at->format('Y-m-d H:i:s');


        $medications = $command->medications;



        foreach ($medications as $medication) {
            $item =   BaseDepot::where('medication_id', $medication->pivot->medication_id)->first();
            $item->quantity += $medication->pivot->quantity;
            $item->save();
        }

        return response()->json([
            'success' => 'supplier items arrived successfully',
            'status' => 'arrived',
            'arrived_at' => $formattedArrivedAt,
        ]);
    }
}
