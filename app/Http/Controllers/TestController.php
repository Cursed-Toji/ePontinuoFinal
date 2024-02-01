<?php

// app/Http/Controllers/TestController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function simpleResponse(Request $request)
    {
        return response()->json([
            'message' => 'Hello, world!'
        ]);
    }
}
