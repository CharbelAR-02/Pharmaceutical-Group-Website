<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    public function show()
    {

        $medications = Medication::paginate(5);
        return view('medications', compact('medications'));
    }

    public function filter(Request $request)
    {

        $term = $request->input('term');
        $criteria = $request->input('criteria');



        // $medicaments = Medicament::where('med_cat', $category)->get();
        $medications = Medication::where($criteria, 'LIKE', $term . '%')->get();

        if ($medications->isEmpty()) {
            $message = 'No medications found.';
        } else {
            $message = null; // No need to display a message if medications are found
        }

        return view('medications_table', compact('medications', 'message'))->render();
    }
}
