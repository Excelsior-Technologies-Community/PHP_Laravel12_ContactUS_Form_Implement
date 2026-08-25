<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\ContactReply;
use App\Models\ContactActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\AdminReplyNotification;
use Illuminate\Support\Facades\Mail;

class ReplyController extends Controller
{
    /**
     * Store admin reply.
     */
    public function store(
        Request $request,
        ContactMessage $contact
    ) {
        $request->validate(
            [
                'reply' => [
                    'required',
                    'string',
                    'min:5',
                    'max:5000',
                ],
            ],
            [
                'reply.required' => 'Please enter your reply.',
                'reply.min' => 'Reply must be at least 5 characters.',
                'reply.max' => 'Reply must not exceed 5000 characters.',
            ]
        );

        $reply = ContactReply::create([
            'contact_message_id' => $contact->id,
            'user_id' => Auth::id(),
            'reply' => $request->reply,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Status
        |--------------------------------------------------------------------------
        */

        $contact->update([
            'status' => 'replied',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Activity Timeline
        |--------------------------------------------------------------------------
        */

        ContactActivity::create([
            'contact_message_id' => $contact->id,
            'user_id' => Auth::id(),
            'type' => 'reply_sent',
            'description' => 'Admin sent a reply to the customer.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Send Email
        |--------------------------------------------------------------------------
        */

        Mail::to($contact->email)
            ->send(new AdminReplyNotification($reply));

        return redirect()
            ->back()
            ->with('success', 'Reply sent successfully!');
    }

    /**
     * Delete admin reply.
     */
    public function destroy(
        ContactMessage $contact,
        ContactReply $reply
    ) {
        if ($reply->contact_message_id !== $contact->id) {
            abort(404);
        }

        $reply->delete();

        return redirect()
            ->back()
            ->with('success', 'Reply deleted successfully!');
    }
}