<?php

namespace App\Http\Controllers;

use App\Models\ContactActivity;
use App\Models\ContactMessage;
use App\Models\ContactNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactNoteController extends Controller
{
    /**
     * Store an internal admin note.
     */
    public function store(Request $request, ContactMessage $contact)
    {
        $request->validate(
            [
                'note' => [
                    'required',
                    'string',
                    'min:3',
                    'max:2000',
                ],
            ],
            [
                'note.required' => 'Please enter an internal note.',
                'note.min' => 'Internal note must be at least 3 characters.',
                'note.max' => 'Internal note must not exceed 2000 characters.',
            ]
        );

        $note = ContactNote::create([
            'contact_message_id' => $contact->id,
            'user_id' => Auth::id(),
            'note' => $request->note,
        ]);

        ContactActivity::create([
            'contact_message_id' => $contact->id,
            'user_id' => Auth::id(),
            'type' => 'note_added',
            'description' => 'Internal note was added.',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Internal note added successfully!');
    }

    /**
     * Delete an internal admin note.
     */
    public function destroy(
        ContactMessage $contact,
        ContactNote $note
    ) {
        // Make sure the note belongs to this contact.
        if ($note->contact_message_id !== $contact->id) {
            abort(404);
        }

        $note->delete();

        ContactActivity::create([
            'contact_message_id' => $contact->id,
            'user_id' => Auth::id(),
            'type' => 'note_deleted',
            'description' => 'An internal note was deleted.',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Internal note deleted successfully!');
    }
}