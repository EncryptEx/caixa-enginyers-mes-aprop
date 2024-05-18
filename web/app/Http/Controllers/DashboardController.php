<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $events = [];
 

        // make petition to api to get json 
        $response = Http::get('http://localhost:3000/solucio.json');

        // dd($response->json()['data']);
    $elems = $response->json()['data'][0];
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

        foreach ($elems as $elem) {
            // dd($elem);
            if($elem['tipus'] == 'sortida'){
                $events[] = [
                    'title' => 'Viatjant a ' . $elem['desti'],
                    'start' => date('Y-m-d H:i:s', strtotime($elem['hora'])),
                    'end' => date('Y-m-d H:i:s', strtotime($elem['hora']) + $elem['temps_trajecte'] * 60),
                ];
                $last = $elem['desti'];
                continue;
            } else {

                $events[] = [
                    'title' => 'Donant servei a ' . $last . ' durant ' . $elem['duracio_estada'] . ' minuts',
                    'start' => date('Y-m-d H:i:s', strtotime($elem['hora'])),
                    'end' => date('Y-m-d H:i:s', strtotime($elem['hora']) + $elem['duracio_estada'] * 60),
                ];
                continue;
            }
        }
 
        return view('dashboard', compact('events'));
    }
}
