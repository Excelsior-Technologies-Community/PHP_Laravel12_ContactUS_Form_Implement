@extends('layouts.admin')

@section('content')

<div class="max-w-6xl mx-auto mt-10 px-4">

    {{-- BACK BUTTON --}}
    <a
        href="{{ route('admin.contacts') }}"
        class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-6 group"
    >
        <svg
            class="w-5 h-5 transition-transform group-hover:-translate-x-1"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
            />
        </svg>

        <span class="font-medium">
            Back to Messages
        </span>
    </a>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div
            class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3"
        >
            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                />
            </svg>

            {{ session('success') }}
        </div>

    @endif


    {{-- VALIDATION ERRORS --}}
    @if($errors->any())

        <div
            class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl"
        >
            <ul class="list-disc list-inside text-sm">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>
        </div>

    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        {{-- ============================================================
            LEFT COLUMN
        ============================================================= --}}

        <div class="lg:col-span-1">

            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-6"
            >

                {{-- CUSTOMER HEADER --}}
                <div
                    class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white text-center"
                >

                    <div
                        class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-3xl mx-auto mb-3 backdrop-blur-sm"
                    >
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>

                    <h2 class="text-xl font-bold">
                        {{ $contact->name }} {{ $contact->last_name }}
                    </h2>

                    <p class="text-blue-100 text-sm">
                        {{ $contact->email }}
                    </p>

                </div>


                {{-- CUSTOMER INFORMATION --}}
                <div class="p-6 space-y-4">

                    {{-- EMAIL --}}
                    <div class="flex items-center gap-3 text-gray-600">

                        <div
                            class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                        </div>

                        <div>

                            <p class="text-xs text-gray-400 uppercase tracking-wider">
                                Email
                            </p>

                            <p class="text-sm font-medium break-all">
                                {{ $contact->email }}
                            </p>

                        </div>

                    </div>


                    {{-- MOBILE --}}
                    <div class="flex items-center gap-3 text-gray-600">

                        <div
                            class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                />
                            </svg>
                        </div>

                        <div>

                            <p class="text-xs text-gray-400 uppercase tracking-wider">
                                Mobile
                            </p>

                            <p class="text-sm font-medium">
                                {{ $contact->mobile }}
                            </p>

                        </div>

                    </div>


                    {{-- SUBJECT --}}
                    @if($contact->subject)

                        <div class="flex items-center gap-3 text-gray-600">

                            <div
                                class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600"
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>

                            <div>

                                <p class="text-xs text-gray-400 uppercase tracking-wider">
                                    Subject
                                </p>

                                <p class="text-sm font-medium">
                                    {{ $contact->subject }}
                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- DATE --}}
                    <div class="flex items-center gap-3 text-gray-600">

                        <div
                            class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>

                        <div>

                            <p class="text-xs text-gray-400 uppercase tracking-wider">
                                Submitted
                            </p>

                            <p class="text-sm font-medium">
                                {{ $contact->created_at->format('d M Y, H:i A') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
            RIGHT COLUMN
        ============================================================= --}}

        <div class="lg:col-span-2 space-y-6">


            {{-- STATUS + PRIORITY --}}
            <div class="flex flex-wrap gap-3">

                <span
                    class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($contact->status == 'new')
                        bg-blue-100 text-blue-700
                    @elseif($contact->status == 'read')
                        bg-yellow-100 text-yellow-700
                    @elseif($contact->status == 'replied')
                        bg-green-100 text-green-700
                    @else
                        bg-gray-100 text-gray-700
                    @endif"
                >
                    {{ ucfirst($contact->status) }}
                </span>


                <span
                    class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($contact->priority == 'low')
                        bg-green-100 text-green-700
                    @elseif($contact->priority == 'medium')
                        bg-yellow-100 text-yellow-700
                    @elseif($contact->priority == 'high')
                        bg-orange-100 text-orange-700
                    @else
                        bg-red-100 text-red-700
                    @endif"
                >
                    {{ ucfirst($contact->priority) }} Priority
                </span>

            </div>


            {{-- ========================================================
                CUSTOMER MESSAGE
            ========================================================= --}}

            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
            >

                <div
                    class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-100"
                >

                    <h3
                        class="font-bold text-gray-800 flex items-center gap-2"
                    >
                        <svg
                            class="w-5 h-5 text-gray-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                            />
                        </svg>

                        Customer Message
                    </h3>

                </div>

                <div class="p-6">

                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">
                        {{ $contact->message }}
                    </p>

                </div>

            </div>


            {{-- ========================================================
                STATUS UPDATE
            ========================================================= --}}

            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
            >

                <div
                    class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100"
                >

                    <h3 class="font-bold text-gray-800">
                        Update Status
                    </h3>

                </div>

                <div class="p-6">

                    <form
                        action="{{ route('admin.contacts.status', $contact) }}"
                        method="POST"
                        class="flex gap-3"
                    >

                        @csrf

                        <select
                            name="status"
                            class="flex-1 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >

                            <option
                                value="new"
                                {{ $contact->status == 'new' ? 'selected' : '' }}
                            >
                                New
                            </option>

                            <option
                                value="read"
                                {{ $contact->status == 'read' ? 'selected' : '' }}
                            >
                                Read
                            </option>

                            <option
                                value="replied"
                                {{ $contact->status == 'replied' ? 'selected' : '' }}
                            >
                                Replied
                            </option>

                            <option
                                value="closed"
                                {{ $contact->status == 'closed' ? 'selected' : '' }}
                            >
                                Closed
                            </option>

                        </select>

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 transition font-medium"
                        >
                            Update
                        </button>

                    </form>

                </div>

            </div>


            {{-- ========================================================
                INTERNAL NOTES
            ========================================================= --}}

            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
            >

                <div
                    class="bg-gradient-to-r from-purple-50 to-fuchsia-50 px-6 py-4 border-b border-gray-100"
                >

                    <h3
                        class="font-bold text-gray-800 flex items-center gap-2"
                    >

                        <svg
                            class="w-5 h-5 text-purple-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M11 5h2m-1-2a9 9 0 100 18 9 9 0 000-18zm0 6v4m0 0l2 2m-2-2l-2 2"
                            />
                        </svg>

                        Internal Admin Notes

                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        Private notes visible only to administrators.
                    </p>

                </div>


                <div class="p-6">

                    {{-- ADD NOTE --}}
                    <form
                        action="{{ route('admin.contacts.note.store', $contact) }}"
                        method="POST"
                        class="mb-6"
                    >

                        @csrf

                        <textarea
                            name="note"
                            rows="3"
                            maxlength="2000"
                            placeholder="Add a private note about this customer/message..."
                            class="w-full border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                            required
                        >{{ old('note') }}</textarea>

                        <div class="flex justify-between items-center mt-3">

                            <span
                                class="text-xs text-gray-400"
                            >
                                Maximum 2000 characters
                            </span>

                            <button
                                type="submit"
                                class="bg-purple-600 text-white px-6 py-2.5 rounded-xl hover:bg-purple-700 transition font-medium"
                            >
                                Add Private Note
                            </button>

                        </div>

                    </form>


                    {{-- NOTES LIST --}}
                    @forelse($contact->notes as $note)

                        <div
                            class="bg-purple-50 border border-purple-100 rounded-xl p-4 mb-3 last:mb-0"
                        >

                            <div
                                class="flex justify-between items-start gap-4"
                            >

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-9 h-9 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-sm"
                                    >
                                        {{ strtoupper(substr($note->user->name ?? 'A', 0, 1)) }}
                                    </div>

                                    <div>

                                        <p class="font-semibold text-gray-800 text-sm">
                                            {{ $note->user->name ?? 'Admin' }}
                                        </p>

                                        <p class="text-xs text-gray-400">
                                            {{ $note->created_at->format('d M Y, H:i A') }}
                                        </p>

                                    </div>

                                </div>


                                <form
                                    action="{{ route('admin.contacts.note.destroy', [$contact, $note]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this internal note?')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-400 hover:text-red-600"
                                        title="Delete Note"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                    </button>

                                </form>

                            </div>


                            <p class="text-gray-700 text-sm leading-relaxed mt-3 whitespace-pre-wrap">
                                {{ $note->note }}
                            </p>

                        </div>

                    @empty

                        <div class="text-center py-6">

                            <div
                                class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3"
                            >
                                <svg
                                    class="w-7 h-7 text-purple-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5h2m-1-2a9 9 0 100 18 9 9 0 000-18zm0 6v4m0 0l2 2m-2-2l-2 2"
                                    />
                                </svg>
                            </div>

                            <p class="text-gray-500 text-sm">
                                No internal notes yet.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- ========================================================
                ACTIVITY TIMELINE
            ========================================================= --}}

            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
            >

                <div
                    class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-100"
                >

                    <h3
                        class="font-bold text-gray-800 flex items-center gap-2"
                    >

                        <svg
                            class="w-5 h-5 text-indigo-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                        Activity Timeline

                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        Complete history of actions performed on this message.
                    </p>

                </div>


                <div class="p-6">

                    @forelse($contact->activities as $activity)

                        <div class="relative flex gap-4 pb-6 last:pb-0">

                            {{-- TIMELINE LINE --}}
                            @if(!$loop->last)

                                <div
                                    class="absolute left-4 top-9 bottom-0 w-px bg-gray-200"
                                ></div>

                            @endif


                            {{-- ICON --}}
                            <div
                                class="relative z-10 w-8 h-8 flex-shrink-0 rounded-full flex items-center justify-center
                                @if($activity->type === 'message_created')
                                    bg-blue-100 text-blue-600
                                @elseif($activity->type === 'status_changed')
                                    bg-yellow-100 text-yellow-600
                                @elseif($activity->type === 'reply_sent')
                                    bg-green-100 text-green-600
                                @elseif($activity->type === 'note_added')
                                    bg-purple-100 text-purple-600
                                @elseif($activity->type === 'note_deleted')
                                    bg-red-100 text-red-600
                                @else
                                    bg-gray-100 text-gray-600
                                @endif"
                            >

                                @if($activity->type === 'message_created')

                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                                        />
                                    </svg>

                                @elseif($activity->type === 'status_changed')

                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                        />
                                    </svg>

                                @elseif($activity->type === 'reply_sent')

                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                        />
                                    </svg>

                                @elseif($activity->type === 'note_added')

                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5h2m-1-2a9 9 0 100 18 9 9 0 000-18zm0 6v4m0 0l2 2m-2-2l-2 2"
                                        />
                                    </svg>

                                @elseif($activity->type === 'note_deleted')

                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 01-1 1v3M4 7h16"
                                        />
                                    </svg>

                                @else

                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"
                                        />
                                    </svg>

                                @endif

                            </div>


                            {{-- ACTIVITY CONTENT --}}
                            <div class="flex-1 min-w-0">

                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1"
                                >

                                    <p class="font-semibold text-gray-800 text-sm">
                                        {{ $activity->description }}
                                    </p>

                                    <span class="text-xs text-gray-400 whitespace-nowrap">
                                        {{ $activity->created_at->format('d M Y, H:i A') }}
                                    </span>

                                </div>


                                <p class="text-xs text-gray-500 mt-1">

                                    @if($activity->user)

                                        By {{ $activity->user->name }}

                                    @else

                                        By Customer

                                    @endif

                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-8">

                            <div
                                class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3"
                            >
                                <svg
                                    class="w-8 h-8 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>

                            <p class="text-gray-500 text-sm">
                                No activity recorded yet.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- ========================================================
                REPLIES
            ========================================================= --}}

            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
            >

                <div
                    class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100"
                >

                    <h3
                        class="font-bold text-gray-800 flex items-center gap-2"
                    >

                        <svg
                            class="w-5 h-5 text-green-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                            />
                        </svg>

                        Replies ({{ $contact->replies->count() }})

                    </h3>

                </div>


                <div class="p-6">

                    @forelse($contact->replies as $reply)

                        <div class="flex gap-4 mb-6 last:mb-0">

                            <div class="flex-shrink-0">

                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm"
                                >
                                    {{ strtoupper(substr($reply->user->name ?? 'A', 0, 1)) }}
                                </div>

                            </div>


                            <div
                                class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-100"
                            >

                                <div
                                    class="flex justify-between items-start mb-2"
                                >

                                    <div>

                                        <span class="font-semibold text-gray-800 text-sm">
                                            {{ $reply->user->name ?? 'Admin' }}
                                        </span>

                                        <span class="text-xs text-gray-400 ml-2">
                                            {{ $reply->created_at->format('d M Y, H:i A') }}
                                        </span>

                                    </div>


                                    <form
                                        action="{{ route('admin.contacts.reply.destroy', [$contact, $reply]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this reply?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-400 hover:text-red-600 transition"
                                        >
                                            <svg
                                                class="w-4 h-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 01-1 1v3M4 7h16"
                                                />
                                            </svg>
                                        </button>

                                    </form>

                                </div>


                                <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">
                                    {{ $reply->reply }}
                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-8">

                            <div
                                class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3"
                            >
                                <svg
                                    class="w-8 h-8 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                    />
                                </svg>
                            </div>

                            <p class="text-gray-500 text-sm">
                                No replies yet. Send the first reply below!
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- ========================================================
                SEND REPLY
            ========================================================= --}}

            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
            >

                <div
                    class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100"
                >

                    <h3
                        class="font-bold text-gray-800 flex items-center gap-2"
                    >
                        Send Reply
                    </h3>

                </div>


                <div class="p-6">

                    <form
                        action="{{ route('admin.contacts.reply', $contact) }}"
                        method="POST"
                    >

                        @csrf

                        <textarea
                            name="reply"
                            rows="4"
                            maxlength="5000"
                            class="w-full border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"
                            placeholder="Type your reply here..."
                            required
                        >{{ old('reply') }}</textarea>


                        <div class="flex justify-end mt-4">

                            <button
                                type="submit"
                                class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-3 rounded-xl hover:from-green-700 hover:to-emerald-700 transition font-medium shadow-md flex items-center gap-2"
                            >

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                    />
                                </svg>

                                Send Reply

                            </button>

                        </div>

                    </form>

                </div>

            </div>


        </div>

    </div>

</div>

@endsection