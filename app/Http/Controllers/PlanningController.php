<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    public function add_booking(Request $request)
    {
        $planning = Planning::create([
            'user_id'  => $request->user_id,
            'coiffeur_id' => $request->coiffeur_id,
            'date' => $request->date
        ]);

        return response()->json([
            'status' => 'success',
            'planning' => $planning,
            'planning' => [
                'coiffeur' => $request->coiffeur_id,
                'date' => $request->date,
            ]
        ]);
    }

    public function delete_booking(Request $request)
    {
        $planning = Planning::drop([
            'user_id'  => $request->user_id,
            'coiffeur_id' => $request->coiffeur_id,
            'date' => $request->date
        ]);

        return response()->json([
            'status' => 'success',
            'planning' => $planning,
            'planning' => [
                'coiffeur' => $request->coiffeur_id,
                'date' => $request->date,
            ]
        ]);
    }

    public function get_booking(Request $request)
    {
    }

    public function get_user_booking(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'planning' => [
                'user' => Auth()->user(),
                'coiffeur' => $request->coiffeur_id,
                'date' => $request->date,
            ]
        ]);
    }
}
