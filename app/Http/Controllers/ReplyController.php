<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\AdminReplyNotification;
use Illuminate\Support\Facades\Mail;

class ReplyController extends Controller
{
    public function store(Request $request, ContactMessage $contact)
    {
        $request->validate([
            'reply' => ['required', 'string', 'min:5'],
        ]);

        $reply = ContactReply::create([
            'contact_message_id' => $contact->id,
            'user_id' => Auth::id(),
            'reply' => $request->reply,
        ]);

        $contact->update(['status' => 'replied']);

        Mail::to($contact->email)->send(new AdminReplyNotification($reply));

        return redirect()->back()->with('success', 'Reply sent successfully!');
    }

    public function destroy(ContactMessage $contact, ContactReply $reply)
    {
        $reply->delete();

        return redirect()->back()->with('success', 'Reply deleted successfully!');
    }
}
