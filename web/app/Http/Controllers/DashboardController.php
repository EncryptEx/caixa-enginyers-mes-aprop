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

        $elems = $response->json();
 
        foreach ($elems as $elem) {
            $events[] = [
                'title' => $elem->client->name . ' ('.$elem->employee->name.')',
                'hora' => $elem->start_time,
                'end' => $elem->finish_time,
            ];
        }
 
        return view('home', compact('events'));
    }
}
