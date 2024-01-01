<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function customerDelete(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::find($id);
        $user = $customer->user;
        $user->delete();

        return response()->json(['success' => 'Customer deleted successfully']);
    }

    public function show($id)
    {
        $user  = User::find($id);
        $customer = $user->customer;
        return view('customer-home', compact('user', 'customer'));
    }

    public function commands($id)
    {
        $user  = User::find($id);
        if ($user->role === "customer") {
            $customer = $user->customer;
            $commands = Command::where('customer_id', $customer->id)->get();
        } else {
            $pharmacist = $user->pharmacist;
            $commands = Command::where('pharmacist_id', $pharmacist->id)->get();
        }


        return view('customer-commands', compact('user', 'commands'));
    }

    public function itemsArrived(Request $request)
    {
        $commandId = $request->input('commandId');
        $command = Command::where('id', $commandId)->first();
        $command->status = "arrived";
        $command->arrived_at = Carbon::now();
        $command->save();

        $formattedArrivedAt = $command->arrived_at->format('Y-m-d H:i:s');
        $user = auth()->user();


        if ($user->role === "pharmacist") {
            $pharmacist = $user->pharmacist;

            $pharmacy = $pharmacist->pharmacy;

            $depot = $pharmacy->depot;

            $depotMedications = $depot->medications;

            $command = Command::where('id', $commandId)
                ->where('pharmacist_id', $pharmacist->id)
                ->first();

            $commandMedications = $command->medications;

            foreach ($commandMedications as $commandMedication) {
                $depotMedication = DB::table('depot_medications')
                    ->where('medication_id', $commandMedication->pivot->medication_id)
                    ->where('depot_id', $depot->id)
                    ->first();
                if ($depotMedication) {
                    $depotMedication->quantity += $commandMedication->pivot->quantity;
                    $depot->medications()->updateExistingPivot(
                        $commandMedication->pivot->medication_id,
                        ['quantity' => $depotMedication->quantity,]
                    );
                } else {
                    $depot->medications()->attach($commandMedication->pivot->medication_id, [
                        'quantity' => $commandMedication->pivot->quantity,
                        'price' => $commandMedication->pivot->unit_price,
                    ]);
                }
            }
        }



        return response()->json([
            'success' => 'Thank you for letting us know that your medications have arrived!Congratulations.',
            'status' => $command->status,
            'arrived_at' => $formattedArrivedAt,
        ]);
    }
}
