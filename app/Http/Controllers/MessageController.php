<?php

namespace App\Http\Controllers;

use App\Mail\MessageReplied as MailMessageReplied;
use App\Models\Message;
use App\Notifications\MessageReplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return Inertia::render('Admin/Messages', ['messages' => $messages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'reply_msg' => 'nullable|string',
        ]);

        $message = new Message();
        $message->first_name = $request->first_name;
        $message->last_name = $request->last_name;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->is_replied = 0;
        $message->save();

        return redirect()->route('contact-us');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return Inertia::render('Admin/ViewMessage', ['message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        
    }

    /**
     * Reply to the specified resource.
     */
    public function reply(Request $request, Message $message)
    {
        $message->reply_msg = $request->reply_msg;
        $message->is_replied = 1;
        $message->save();
        Mail::to($message->email)->send(new MailMessageReplied($request->reply_msg));
        return redirect()->route('admin.messages');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages');
    }
}
