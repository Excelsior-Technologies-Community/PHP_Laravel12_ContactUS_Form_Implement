@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto mt-10 px-4">
    {{-- BACK BUTTON --}}
    <a href="{{ route('admin.contacts') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-6 group">
        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span class="font-medium">Back to Messages</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- LEFT COLUMN: CUSTOMER INFO --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white text-center">
                    <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-3xl mx-auto mb-3 backdrop-blur-sm">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold">{{ $contact->name }} {{ $contact->last_name }}</h2>
                    <p class="text-blue-100 text-sm">{{ $contact->email }}</p>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-3 text-gray-600">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Email</p>
                            <p class="text-sm font-medium">{{ $contact->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 text-gray-600">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Mobile</p>
                            <p class="text-sm font-medium">{{ $contact->mobile }}</p>
                        </div>
                    </div>

                    @if($contact->subject)
                    <div class="flex items-center gap-3 text-gray-600">
                        <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Subject</p>
                            <p class="text-sm font-medium">{{ $contact->subject }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center gap-3 text-gray-600">
                        <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Submitted</p>
                            <p class="text-sm font-medium">{{ $contact->created_at->format('d M Y, H:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: MESSAGE + REPLIES --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- STATUS & PRIORITY BADGES --}}
            <div class="flex flex-wrap gap-3">
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($contact->status == 'new') bg-blue-100 text-blue-700
                    @elseif($contact->status == 'read') bg-yellow-100 text-yellow-700
                    @elseif($contact->status == 'replied') bg-green-100 text-green-700
                    @else bg-gray-100 text-gray-700
                    @endif">
                    {{ ucfirst($contact->status) }}
                </span>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($contact->priority == 'low') bg-green-100 text-green-700
                    @elseif($contact->priority == 'medium') bg-yellow-100 text-yellow-700
                    @elseif($contact->priority == 'high') bg-orange-100 text-orange-700
                    @else bg-red-100 text-red-700
                    @endif">
                    {{ ucfirst($contact->priority) }} Priority
                </span>
            </div>

            {{-- MESSAGE CARD --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Customer Message
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $contact->message }}</p>
                </div>
            </div>

            {{-- STATUS UPDATE CARD --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Update Status
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.contacts.status', $contact) }}" method="POST" class="flex gap-3">
                        @csrf
                        <select name="status" class="flex-1 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="new" {{ $contact->status == 'new' ? 'selected' : '' }}>New</option>
                            <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Replied</option>
                            <option value="closed" {{ $contact->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 transition font-medium shadow-md hover:shadow-lg">
                            Update
                        </button>
                    </form>
                </div>
            </div>

            {{-- REPLIES SECTION --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Replies ({{ $contact->replies->count() }})
                    </h3>
                </div>
                <div class="p-6">
                    @forelse($contact->replies as $reply)
                        <div class="flex gap-4 mb-6 last:mb-0">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ strtoupper(substr($reply->user->name ?? 'A', 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="font-semibold text-gray-800 text-sm">{{ $reply->user->name ?? 'Admin' }}</span>
                                        <span class="text-xs text-gray-400 ml-2">{{ $reply->created_at->format('d M Y, H:i A') }}</span>
                                    </div>
                                    <form action="{{ route('admin.contacts.reply.destroy', [$contact, $reply]) }}" method="POST" onsubmit="return confirm('Delete this reply?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $reply->reply }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <p class="text-gray-500 text-sm">No replies yet. Send the first reply below!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- SEND REPLY CARD --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Send Reply
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea name="reply" rows="4" class="w-full border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none" placeholder="Type your reply here..." required>{{ old('reply') }}</textarea>
                            @error('reply')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-3 rounded-xl hover:from-green-700 hover:to-emerald-700 transition font-medium shadow-md hover:shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
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
