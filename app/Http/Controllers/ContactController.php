<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

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
            // ✅ Name: only letters & space
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],

            // ✅ Last Name: only letters & space
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],

            // ✅ Email: must be @gmail.com
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],

            // ✅ Mobile: exactly 10 digits
            'mobile' => [
                'required',
                'digits:10'
            ],

            // ✅ Message
            'message' => [
                'required',
                'string',
                'min:5'
            ],
        ],
        [
            // 🔴 Custom Error Messages
            'name.required' => 'Please enter your first name',
            'name.regex' => 'Name should contain only letters',

            'last_name.required' => 'Please enter your last name',
            'last_name.regex' => 'Last name should contain only letters',

            'email.required' => 'Please enter your email',
            'email.regex' => 'Email must be a valid Gmail address',

            'mobile.required' => 'Please enter your mobile number',
            'mobile.digits' => 'Mobile number must be exactly 10 digits',

            'message.required' => 'Please enter your message',
            'message.min' => 'Message must be at least 5 characters',
        ]
    );

    ContactMessage::create([
        'name' => $request->name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'message' => $request->message,
    ]);

    return redirect()->back()->with('success', '✅ Message sent successfully!');
}
   public function adminIndex(Request $request)
{
    $search = $request->search;

    $messages = ContactMessage::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(4)
        ->withQueryString(); // pagination + search maintain

    // 🔥 AJAX REQUEST (Live Search)
    if ($request->ajax()) {
        return view('admin.contacts.partials.table', compact('messages'))->render();
    }

    return view('admin.contacts.index', compact('messages', 'search'));
}


}
