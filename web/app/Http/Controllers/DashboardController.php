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

        foreach ($elems as $elem) {
            if($elem['tipus'] == 'sortida'){
                $events[] = [
                    'title' => 'Viatjant desde ' . $elem['lloc_sortida'] . ' a ' . $elem['desti'],
                    'start' => (new \DateTime($elem['hora']))->format(\DateTime::ATOM),
                    'end' => (new \DateTime($elem['hora']))->modify('+' . $elem['temps_trajecte'] . ' minutes')->format(\DateTime::ATOM),
                ];
                $last = $elem['desti'];
                continue;
            } else {
                
                $events[] = [
                    'title' => 'Donant servei a ' . $last . ' durant ' . $elem['duracio_estada'] . ' minuts',
                    'start' => (new \DateTime($elem['hora']))->format(\DateTime::ATOM),
                    'end' => (new \DateTime($elem['hora']))->modify('+' . $elem['duracio_estada'] . ' minutes')->format(\DateTime::ATOM),
                ];
                continue;
            }
        }
 
        return view('dashboard', compact('events'));
    }
}
