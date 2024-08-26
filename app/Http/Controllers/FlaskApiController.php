<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlaskApiController extends Controller
{
    private $apiUrl = 'https://4710-35-233-253-40.ngrok-free.app/chat'; // Your Ngrok URL

    public function chat(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'message' => 'required|string',
        ]);

        // Send request to Flask API
        $response = Http::withoutVerifying()->post($this->apiUrl, [
            'message' => $request->input('message'),
        ]);

        // Return the response from Flask API as JSON
        return response()->json(['response' => $response->body()]);
    }
}
