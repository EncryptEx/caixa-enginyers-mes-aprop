<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    function view(Request $request)
    {
        $usr = $request->user();
        
        if($request->user()->role == 'user'){
            return view('feedback');
        }
        
        $events = [];
 

        // make petition to api to get json 
        $response = Http::get(env('DATA_URI', 'http://localhost:3000/solucio.json'),);

        $elems = $response->json()['data'];


        // {
        //     "data": [
        //       [
        //         {
        //           "tipus": "sortida",
        //           "hora": "2024-05-18T09:00:00+02:00",
        //           "temps_trajecte": "60",
        //           "lloc_sortida": "ribes de frezer",
        //           "desti": "berga"
        //         },

        $today = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format

        $events = [];
        
        foreach ($elems as $elem) {
            // Check if the event is a 'sortida' and its date matches the current date
            if ($elem['tipus'] == 'sortida' && substr($elem['hora'], 0, 10) == $today) {
                $events[] = [
                    'title' => 'Viatjant a ' . $elem['desti'],
                    'lloc_sortida' => $elem['lloc_sortida'],
                    'desti' => $elem['desti'],
                ];
                $last = $elem['desti'];
            }
        }
        
        // Now $events will contain only events from the current day
        
 
        return view('map', compact('events'));
    }
}
