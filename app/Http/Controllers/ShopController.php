<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BaseDepot;
use App\Models\Command;
use App\Models\Customer;
use App\Models\Depot;
use App\Models\Medication;
use App\Models\Pharmacist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        $medications = BaseDepot::where('price', '<>', null)->paginate(4);
        return view('shop', compact('user', 'medications'));
    }

    public function addCart(Request $request)
    {
        //get the data from the request
        $quantity = $request->input('quantity');
        $price = $request->input('med_price');
        $med_id = $request->input('med_id');
        $user_id = $request->input('user_id');

        //Item Total calcul
        $itemTotal = $quantity * $price;

        $medication = Medication::find($med_id);
        $user = User::find($user_id);

        if ($user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();

            // check if there a pending command for the user
            $command = Command::where('customer_id', $customer->id)
                ->where('status', 'pending')
                ->first();

            //if the command doesn't exist make a new command
            if (!$command) {
                $command = new Command();
                $command->customer_id = $customer->id;
            }
        } else {
            $pharmacist = Pharmacist::where('user_id', $user->id)->first();
            $command = Command::where('pharmacist_id', $pharmacist->id)
                ->where('status', 'pending')
                ->first();

            if (!$command) {
                $command = new Command();
                $command->pharmacist_id = $pharmacist->id;
            }
        }
        $command->total_price += $itemTotal;
        $command->save();

        //checking if the command medication already addded to cart
        $existingCommandMedication = $command->medications()->where('medication_id', $med_id)->first();

        //if it is added already update the quantity
        if ($existingCommandMedication) {
            $command->medications()->updateExistingPivot($med_id, [
                'quantity' => $quantity,
                'item_total' => $itemTotal,
            ]);
            //else make a new command medication
        } else {
            $command->medications()->attach($medication, ['quantity' => $quantity, 'unit_price' => $price, 'item_total' => $itemTotal]);
        }

        return response()->json([
            'success' => 'Item added to cart',
        ]);
    }

    public function cancelCommand(Request $request)
    {

        $commandId = $request->input('id');

        // Retrieve the command from the database and update its status
        $command = Command::find($commandId);

        if ($command) {
            $command->status = 'cancelled';
            $command->save();

            return response()->json([
                'success' => 'Command cancelled successfully',
                'cartIsEmpty' => true, // Set to true if the cart is empty
                'cartHtml' => 'Your cart is empty', // This should be HTML content of the cart items if not empty
            ]);
        }

        return response()->json(['success' => false]);
    }

    function deleteCart(Request $request)
    {
        $commandId = $request->input('commandId');
        $commandMedId = $request->input('commandMedId');

        $command = Command::find($commandId);

        $deleteItem =   DB::table('command_medications')
            ->where('command_id', $commandId)
            ->where('id', $commandMedId)
            ->first();

        $itemTotal = $deleteItem->item_total;

        $newTotalPrice = $command->total_price - $itemTotal;

        $command->total_price = $newTotalPrice;
        $command->save();

        $formattedPrice = number_format($newTotalPrice, 2);

        DB::table('command_medications')
            ->where('command_id', $commandId)
            ->where('id', $commandMedId)
            ->delete();

        $isCommandEmpty = DB::table('command_medications')
            ->where('command_id', $commandId)
            ->count() === 0;

        // Optionally, you can delete the command itself if it's empty
        if ($isCommandEmpty) {
            Command::find($commandId)->delete();
        }

        return response()->json([
            'success' => 'Item deleted from cart',
            'newTotalPrice' => $formattedPrice,
        ]);
    }

    public function confirmCommand(Request $request)
    {
        $commandId = $request->input('id');
        $command = Command::find($commandId);
        $totalPrice = 0;

        if ($command) {
            $command->status = 'confirmed';
            $command->save();
        }

        return response()->json([
            'success' => 'command confirmed successfully',
        ]);
    }
}
