<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show contact page
     */
    public function index()
    {
        return view('user.contact');
    }

    /**
     * Store contact message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Mesej anda telah dihantar! Kami akan menghubungi anda tidak lama lagi. 😊');
    }
}
