<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Services\PipedriveAPI;

class ThegameController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Thegame/Index');
    }
}
