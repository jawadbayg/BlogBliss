<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlaskApiController extends Controller
{
    private $apiUrl = 'https://ddaf-34-83-45-38.ngrok-free.app/chat'; 

    public function chat(Request $request)
    {
        
        $request->validate([
            'message' => 'required|string',
        ]);

        
        $response = Http::withoutVerifying()->post($this->apiUrl, [
            'message' => $request->input('message'),
        ]);

       
        return response()->json(['response' => $response->body()]);
    }
}
