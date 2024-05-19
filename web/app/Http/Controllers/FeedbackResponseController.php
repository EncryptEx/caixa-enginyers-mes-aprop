<?php

namespace App\Http\Controllers;

use App\Models\FeedbackResponse;
use Illuminate\Http\Request;

class FeedbackResponseController extends Controller
{
    // Handle form submission
    public function handleForm(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'municipi' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'time_increment' => 'required|numeric',
            'timetable' => 'required|numeric|min:1|max:3'
        ]);


        // Save the form data to the database
        $form = new FeedbackResponse();
        $form->municipi = $validated['municipi'];
        $form->rating = $validated['rating'];
        $form->time_increment = $validated['time_increment'];
        $form->timetable = $validated['timetable'];
        $form->save();


        // Redirect back with a success message
        return redirect()->route('success')->with('success', 'Formulari enviat satisfatòriament!');
    }
}
