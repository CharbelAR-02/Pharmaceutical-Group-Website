<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Customer;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);

        if ($user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $command = Command::where('customer_id', $customer->id)
                ->where('status', 'pending')
                ->first();
        } else {
            $pharmacist = Pharmacist::where('user_id', $user->id)->first();
            $command = Command::where('pharmacist_id', $pharmacist->id)
                ->where('status', 'pending')
                ->first();
        }

        $commandMedications = $command ? $command->medications : collect();
        return view('cart', compact('commandMedications', 'command'));
    }
}
