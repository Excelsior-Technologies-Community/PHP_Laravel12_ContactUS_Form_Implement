<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Mail\ContactSubmitted;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReplyNotification;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        return view('customer.contact');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
                'mobile' => ['required', 'digits:10'],
                'subject' => ['nullable', 'string', 'max:255'],
                'priority' => ['required', 'in:low,medium,high,urgent'],
                'message' => ['required', 'string', 'min:5'],
            ],
            [
                'name.required' => 'Please enter your first name',
                'name.regex' => 'Name should contain only letters',
                'last_name.required' => 'Please enter your last name',
                'last_name.regex' => 'Last name should contain only letters',
                'email.required' => 'Please enter your email',
                'email.regex' => 'Email must be a valid Gmail address',
                'mobile.required' => 'Please enter your mobile number',
                'mobile.digits' => 'Mobile number must be exactly 10 digits',
                'subject.max' => 'Subject must not exceed 255 characters',
                'priority.required' => 'Please select a priority level',
                'priority.in' => 'Please select a valid priority level',
                'message.required' => 'Please enter your message',
                'message.min' => 'Message must be at least 5 characters',
            ]
        );

        $contact = ContactMessage::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'subject' => $request->subject,
            'priority' => $request->priority,
            'message' => $request->message,
            'status' => 'new',
        ]);

        Mail::to($contact->email)->send(new ContactSubmitted($contact));

        return redirect()->route('contact.tracking', $contact->id)->with('success', '✅ Message sent successfully!');
    }

    public function adminIndex(Request $request)
    {
        $search = $request->search;
        $priority = $request->priority;
        $status = $request->status;

        $messages = ContactMessage::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('mobile', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%")
                      ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->when($priority, function ($query, $priority) {
                $query->where('priority', $priority);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.contacts.partials.table', compact('messages'))->render();
        }

        return view('admin.contacts.index', compact('messages', 'search', 'priority', 'status'));
    }

    public function show(ContactMessage $contact)
    {
        $contact->load('replies.user');
        return view('admin.contacts.show', compact('contact'));
    }

    public function trackingForm(Request $request)
    {
        $contact = null;
        if ($request->has('id')) {
            $contact = ContactMessage::find($request->id);
        }
        return view('customer.tracking', compact('contact'));
    }

    public function tracking($id)
    {
        $contact = ContactMessage::findOrFail($id);
        return view('customer.tracking', compact('contact'));
    }

    public function updateStatus(Request $request, ContactMessage $contact)
    {
        $request->validate([
            'status' => ['required', 'in:new,read,replied,closed'],
        ]);

        $contact->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}
