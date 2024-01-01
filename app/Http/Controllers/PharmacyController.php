<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Depot;
use App\Models\Pharmacy;


class PharmacyController extends Controller
{
    public function addPharmacy(Request $request)
    {
        $ph = Pharmacy::create([
            'name' => $request->name,
            'location' => $request->location
        ]);
        $depot =  Depot::create([
            'pharmacy_id' => $ph->id,
        ]);
        return response()->json([
            'success' => 'pharmacy has been added',
            'row' => '<tr id="rowPharmacy_' . $ph->id . '">
            <td>
            <span class="pharm-name" id="Pharm_name_' . $ph->id . '">'
                . $ph->name . '
            </span>
            <input type="text" class="pharm-input" id="Edit_Pharm_name_' . $ph->id . '"
                value=' . $ph->name . '  style="display: none;"/>
        </td>

        <td>
        <span class="pharm-loc" id="Pharm_loc_' . $ph->id . '">' .
                $ph->location . '
        </span>
        <input type="text" class="pharm-input" id="Edit_Pharm_loc_' . $ph->id . '"
            value="' . $ph->location . '" style="display: none;" />
    </td>
    <td>
       <button type="button" class="btn btn-primary btnEdit"
        data-id="' . $ph->id . '">Edit</button>
        <button type="button" class="btn btn-primary"
        onclick="deletePharmacy(' . $ph->id . ')">Delete</button>
        <button type="button" class="btn btn-primary btnUpdate"
        onclick="updatePharmacy(' . $ph->id . ')"
        id="btnUpdate_' . $ph->id . '" style="display: none;">update</button>
      </td>
               </tr>'
        ]);
    }

    public function deletePharmacy(Request $request)
    {
        $ph = Pharmacy::find($request->id);
        $ph->delete();
        return response()->json(['success' => 'pharmacy has been deleted']);
    }

    public function updatePharmacy(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $loc = $request->input('loc');

        $pharmacy = Pharmacy::find($id);
        $pharmacy->name = $name;
        $pharmacy->location = $loc;
        $pharmacy->save();
        return response()->json(['success' => 'pharmacy has been updated']);
    }
}
