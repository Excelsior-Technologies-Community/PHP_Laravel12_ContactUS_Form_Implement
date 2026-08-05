@extends('layouts.customer')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Track Your Message</h1>
            <p class="text-gray-600">Enter your message ID to check its current status</p>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                <h2 class="text-2xl font-bold">Message Tracker</h2>
                <p class="text-blue-100 mt-1">Find your message using the ID sent to your email</p>
            </div>

            <div class="p-8">
                <form action="{{ route('contact.tracking.form') }}" method="GET" class="flex gap-3">
                    <input type="text" name="id" value="{{ request('id') }}" placeholder="Enter Message ID (e.g., 1)" class="flex-1 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 transition font-medium">
                        Track
                    </button>
                </form>

                @if(isset($contact) && $contact)
                    <div class="mt-8">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Message Status</h3>
                            <div class="flex items-center gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-sm font-medium text-gray-500">Status:</span>
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            @if($contact->status == 'new') bg-blue-100 text-blue-700
                                            @elseif($contact->status == 'read') bg-yellow-100 text-yellow-700
                                            @elseif($contact->status == 'replied') bg-green-100 text-green-700
                                            @else bg-gray-100 text-gray-700
                                            @endif">
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-500">Priority:</span>
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            @if($contact->priority == 'low') bg-green-100 text-green-700
                                            @elseif($contact->priority == 'medium') bg-yellow-100 text-yellow-700
                                            @elseif($contact->priority == 'high') bg-orange-100 text-orange-700
                                            @else bg-red-100 text-red-700
                                            @endif">
                                            {{ ucfirst($contact->priority) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Submitted</p>
                                    <p class="font-semibold">{{ $contact->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
                            <h4 class="font-semibold text-gray-700 mb-2">Your Message</h4>
                            <p class="text-gray-600">{{ $contact->message }}</p>
                        </div>

                        @if($contact->replies->count() > 0)
                            <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
                                <h4 class="font-semibold text-gray-700 mb-4">Replies</h4>
                                @foreach($contact->replies as $reply)
                                    <div class="bg-blue-50 rounded-lg p-4 mb-3 border-l-4 border-blue-500">
                                        <p class="text-gray-700">{{ $reply->reply }}</p>
                                        <p class="text-sm text-gray-500 mt-2">{{ $reply->user->name ?? 'Admin' }} - {{ $reply->created_at->format('d M Y, H:i A') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @elseif(request('id'))
                    <div class="mt-8 bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                        <svg class="w-12 h-12 mx-auto text-red-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-red-700 font-medium">No message found with ID: {{ request('id') }}</p>
                        <p class="text-red-600 text-sm mt-1">Please check your message ID and try again.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
