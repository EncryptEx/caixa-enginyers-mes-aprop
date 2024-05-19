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
        $api_uri = env('API_URI', 'http://localhost:8000/generate');

        // create an array of all feedbackREsponse entries
        $feedbackResponses = FeedbackResponse::all();

        dd($feedbackResponses->toJson());

        Http::post($api_uri, [
            'feedbackResponses' => $feedbackResponses->toJson(),
        ]);

        return redirect()->route('success')->with('success', 'Acció enviada satisfatòriament!');
    }
}
