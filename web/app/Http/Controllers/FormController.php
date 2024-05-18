<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    // Handle form submission
    public function handleForm(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Process the form data (e.g., save to the database)
        // In this example, we'll just return the data to the view

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Form submitted successfully!');
    }
}
