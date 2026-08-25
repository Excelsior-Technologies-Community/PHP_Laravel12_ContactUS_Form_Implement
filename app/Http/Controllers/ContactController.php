<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\ContactActivity;
use App\Mail\ContactSubmitted;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display customer contact form.
     */
    public function index()
    {
        return view('customer.contact');
    }

    /**
     * Store customer contact message.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-zA-Z\s]+$/',
                ],

                'last_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-zA-Z\s]+$/',
                ],

                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                ],

                'mobile' => [
                    'required',
                    'digits:10',
                ],

                'subject' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'priority' => [
                    'required',
                    'in:low,medium,high,urgent',
                ],

                'message' => [
                    'required',
                    'string',
                    'min:5',
                ],
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

        ContactActivity::create([
            'contact_message_id' => $contact->id,
            'user_id' => null,
            'type' => 'message_created',
            'description' => 'Customer submitted a new contact message.',
        ]);

        Mail::to($contact->email)
            ->send(new ContactSubmitted($contact));

        return redirect()
            ->route('contact.tracking', $contact->id)
            ->with('success', '✅ Message sent successfully!');
    }

    /**
     * Admin message listing.
     *
     * NEW:
     * - Search
     * - Priority filter
     * - Status filter
     * - Date range filter
     * - Per page
     * - Sorting
     */
    public function adminIndex(Request $request)
    {
        $search = $request->search;
        $priority = $request->priority;
        $status = $request->status;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $allowedPerPage = [6, 10, 20, 50];

        $perPage = (int) $request->get('per_page', 6);

        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 6;
        }

        $sort = $request->get('sort', 'latest');

        $query = ContactMessage::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $query->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Priority
        |--------------------------------------------------------------------------
        */

        $query->when($priority, function ($query, $priority) {
            $query->where('priority', $priority);
        });

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        $query->when($status, function ($query, $status) {
            $query->where('status', $status);
        });

        /*
        |--------------------------------------------------------------------------
        | Date From
        |--------------------------------------------------------------------------
        */

        $query->when($fromDate, function ($query, $fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        });

        /*
        |--------------------------------------------------------------------------
        | Date To
        |--------------------------------------------------------------------------
        */

        $query->when($toDate, function ($query, $toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        });

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'name_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('name', 'desc');
        } elseif ($sort === 'priority') {
            $query->orderByRaw("
                CASE priority
                    WHEN 'urgent' THEN 1
                    WHEN 'high' THEN 2
                    WHEN 'medium' THEN 3
                    WHEN 'low' THEN 4
                    ELSE 5
                END
            ");
        } else {
            $query->latest();
        }

        $messages = $query
            ->paginate($perPage)
            ->withQueryString();

        if ($request->ajax()) {
            return view(
                'admin.contacts.partials.table',
                compact('messages')
            )->render();
        }

        return view(
            'admin.contacts.index',
            compact(
                'messages',
                'search',
                'priority',
                'status',
                'fromDate',
                'toDate',
                'perPage',
                'sort'
            )
        );
    }

    /**
     * Display message details.
     *
     * NEW:
     * Automatically mark "new" message as "read".
     */
    public function show(ContactMessage $contact)
    {
        if ($contact->status === 'new') {

            $contact->update([
                'status' => 'read',
            ]);

            ContactActivity::create([
                'contact_message_id' => $contact->id,
                'user_id' => auth()->id(),
                'type' => 'status_changed',
                'description' => 'Message automatically marked as read when opened by admin.',
            ]);
        }

        $contact->load([
            'replies.user',
            'notes.user',
            'activities.user',
        ]);

        return view(
            'admin.contacts.show',
            compact('contact')
        );
    }

    /**
     * Customer tracking form.
     */
    public function trackingForm(Request $request)
    {
        $contact = null;

        if ($request->has('id')) {
            $contact = ContactMessage::with('replies.user')
                ->find($request->id);
        }

        return view(
            'customer.tracking',
            compact('contact')
        );
    }

    /**
     * Track specific message.
     */
    public function tracking($id)
    {
        $contact = ContactMessage::with('replies.user')
            ->findOrFail($id);

        return view(
            'customer.tracking',
            compact('contact')
        );
    }

    /**
     * Update message status.
     */
    public function updateStatus(
        Request $request,
        ContactMessage $contact
    ) {
        $request->validate([
            'status' => [
                'required',
                'in:new,read,replied,closed',
            ],
        ]);

        $oldStatus = $contact->status;
        $newStatus = $request->status;

        $contact->update([
            'status' => $newStatus,
        ]);

        if ($oldStatus !== $newStatus) {
            ContactActivity::create([
                'contact_message_id' => $contact->id,
                'user_id' => auth()->id(),
                'type' => 'status_changed',
                'description' =>
                "Status changed from " .
                    ucfirst($oldStatus) .
                    " to " .
                    ucfirst($newStatus) .
                    ".",
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Status updated successfully!');
    }

    /**
     * NEW FEATURE 1
     * Export filtered messages to CSV.
     */
    public function exportCsv(Request $request)
    {
        $search = $request->search;
        $priority = $request->priority;
        $status = $request->status;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $query = ContactMessage::query();

        $query->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        });

        $query->when($priority, function ($query, $priority) {
            $query->where('priority', $priority);
        });

        $query->when($status, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($fromDate, function ($query, $fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        });

        $query->when($toDate, function ($query, $toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        });

        $messages = $query
            ->latest()
            ->get();

        $filename = 'contact-messages-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($messages) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Name',
                'Last Name',
                'Email',
                'Mobile',
                'Subject',
                'Priority',
                'Status',
                'Message',
                'Created At',
            ]);

            foreach ($messages as $message) {
                fputcsv($file, [
                    $message->id,
                    $message->name,
                    $message->last_name,
                    $message->email,
                    $message->mobile,
                    $message->subject,
                    $message->priority,
                    $message->status,
                    $message->message,
                    $message->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * NEW FEATURE 2
     * Bulk delete messages.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => [
                'required',
                'array',
                'min:1',
            ],

            'ids.*' => [
                'integer',
                'exists:contact_messages,id',
            ],
        ]);

        $ids = $request->ids;

        ContactMessage::whereIn('id', $ids)->delete();

        return redirect()
            ->route('admin.contacts')
            ->with(
                'success',
                count($ids) . ' contact message(s) deleted successfully!'
            );
    }
}
