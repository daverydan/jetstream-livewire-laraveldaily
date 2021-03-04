<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Message;
use App\Notifications\ListingMessageNotification;
use Illuminate\Http\Request;
// use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;

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
        $listing = Listing::with('user')->findOrFail($request->listing_id);
        // check if there are more than 5 messages sent within the last minute
        $sentMessages = Message::where('user_id', auth()->id())
            ->where('created_at', '>', now()->subMinute())
            ->count();
        if ($sentMessages < 5) {
            // save msg
            Message::create([
                'user_id' => auth()->id(),
                'listing_id' => request()->listing_id,
                'message_text' => request()->message,
            ]);
            // send msg
            $message = [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'listingTitle' => $listing->title,
                'messageText' => $request->message,
            ];
            Notification::route('mail', $listing->user->email)
                ->notify(new ListingMessageNotification($message));
            // TODO: set up mail in .env & test if mail sends
        }
        return redirect()->route('listings.index')->with('message', 'Message sent.');
    }
}
