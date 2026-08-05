<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($messages as $msg)
        <div class="flip-card h-96">
            <div class="flip-card-inner w-full h-full relative">
                {{-- FRONT SIDE --}}
                <div class="flip-card-front absolute inset-0 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden cursor-pointer"
                     onclick="window.location='{{ route('admin.contacts.show', $msg) }}'">
                    <div class="p-6 h-full flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $msg->name }} {{ $msg->last_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $msg->email }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($msg->status == 'new') bg-blue-100 text-blue-700
                                @elseif($msg->status == 'read') bg-yellow-100 text-yellow-700
                                @elseif($msg->status == 'replied') bg-green-100 text-green-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($msg->status) }}
                            </span>
                        </div>
                        
                        <div class="space-y-2 mb-4 flex-1">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $msg->mobile }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                {{ ucfirst($msg->priority) }} Priority
                            </div>
                            @if($msg->subject)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                {{ $msg->subject }}
                            </div>
                            @endif
                        </div>

                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $msg->message }}</p>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-400">{{ $msg->created_at->format('d M Y, H:i A') }}</span>
                            <button onclick="event.stopPropagation(); this.closest('.flip-card').querySelector('.flip-card-inner').classList.toggle('flipped')" class="text-blue-600 text-sm font-medium hover:text-blue-700 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Flip for QR
                            </button>
                        </div>
                    </div>
                </div>

                {{-- BACK SIDE --}}
                <div class="flip-card-back absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl shadow-lg border border-gray-700 overflow-hidden flex flex-col items-center justify-center p-6 text-white">
                    <h3 class="text-lg font-bold mb-1">Scan QR Code</h3>
                    <p class="text-gray-300 text-xs mb-4 text-center">Scan to view message details on mobile</p>
                    
                    <div class="bg-white p-2 rounded-lg shadow-lg mb-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode(route('contact.tracking', $msg->id)) }}" 
                             alt="QR Code" 
                             class="w-28 h-28"
                             onerror="this.src='https://via.placeholder.com/120?text=QR'">
                    </div>
                    
                    <p class="text-[10px] text-gray-400 text-center break-all mb-4 leading-tight">
                        {{ route('contact.tracking', $msg->id) }}
                    </p>

                    <div class="flex gap-2 w-full">
                        <button onclick="event.stopPropagation(); window.location='{{ route('admin.contacts.show', $msg) }}'" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium py-2 px-3 rounded-lg transition">
                            View Details
                        </button>
                        <button onclick="event.stopPropagation(); this.closest('.flip-card').querySelector('.flip-card-inner').classList.toggle('flipped')" class="bg-gray-700 hover:bg-gray-600 text-white text-xs font-medium py-2 px-3 rounded-lg transition">
                            Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            <p class="text-gray-500">No messages found</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $messages->links() }}
</div>
