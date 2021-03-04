<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['message' => 'required']);
        // save msg
        $sentMessages = Message::where('user_id', auth()->id())
            ->where('created_at', '>', now()->subMinute())
            ->count();
        if ($sentMessages < 5) {
            Message::create([
                'user_id' => auth()->id(),
                'listing_id' => request()->listing_id,
                'message_text' => request()->message,
            ]);
        }
        return redirect()->route('listings.index')->with('message', 'Message sent.');
        // send msg
    }
}
