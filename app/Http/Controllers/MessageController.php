<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('messages.index');
    }

    public function show($conversation)
    {
        return view('messages.show', compact('conversation'));
    }

    public function store(Request $request)
    {
        // Logique d'envoi de message
        return redirect()->back();
    }
}
