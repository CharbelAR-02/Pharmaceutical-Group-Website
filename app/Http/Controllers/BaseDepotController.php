<?php

namespace App\Http\Controllers;

use App\Models\BaseDepot;
use Illuminate\Http\Request;

class BaseDepotController extends Controller
{
    public function updateBaseDepotItem(Request $request)
    {

        $id = $request->input('id');
        $price = $request->input('med_price');
        $basedepot = BaseDepot::find($id);
        if ($basedepot) {
            $basedepot->price = $price;
            $basedepot->save();
        }
        return response()->json(['success' => 'base depot item updated successfully']);
    }

    public function deleteBaseDepotItem(Request $request)
    {
        $id = $request->input('id');
        $basedepot = BaseDepot::find($id);
        $basedepot->delete();
        return response()->json(['success' => 'base depot item deleted successfully']);
    }
}
