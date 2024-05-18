<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class LiveController extends Controller
{
    public function display(){
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
        
        $i = 0;
        $now = Carbon::now('CEST')->timestamp;
        // get the time of today but 23:59:59
        
        $day = Carbon::now('CEST')->endOfDay()->timestamp;

        $datt = Carbon::parse($elems[$i]['hora'])->timestamp;

        while($datt < $now){
            $i++;
            $datt = Carbon::parse($elems[$i]['hora'])->timestamp;
            
            
            if($i > count($elems) - 1 or $datt > $day){
                return view('live');
            }
        }
        
        
        if($i > count($elems) - 1 or $datt > $day) return view('live');
        return view('live', ['event'=> $elems[$i]]);
    }
}
