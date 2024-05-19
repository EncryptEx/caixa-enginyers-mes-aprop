<?php

namespace App\Http\Controllers;

use App\Models\FeedbackResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GenerateController extends Controller
{
    public function view()
    {
        return view('generate');
    }
    public function store(Request $request)
    {

        // access API_URI from .env file
        $api_uri = env('DATA_URI', 'http://localhost:8000/generate') . '/generate';

        // create an array of all feedbackREsponse entries
        $feedbackResponses = FeedbackResponse::all();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($api_uri, $feedbackResponses->toArray());

        // Handle the response
        if ($response->successful()) {
            return redirect()->route('success')->with('success', 'Acció enviada satisfatòriament!');
        } else {
            return redirect()->route('success')->with('error', 'Acció enviada erròniament!'. $response->body());
            
        }

    }
}
