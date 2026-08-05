@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto mt-10 px-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Customer Messages</h2>
            <p class="text-gray-500 mt-1">Manage and respond to customer inquiries</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('dashboard') }}" class="bg-gray-800 text-white px-6 py-3 rounded-xl hover:bg-gray-900 transition font-medium inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.contacts') }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search messages..."
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select name="priority" class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">All Priorities</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
            </select>
            <select name="status" class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Filter
            </button>
            <a href="{{ route('admin.contacts') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                Reset
            </a>
        </form>
    </div>

    {{-- MESSAGES CARDS --}}
    <div id="messages-container">
        @include('admin.contacts.partials.table')
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = new URL(window.location.href);
    
    formData.forEach((value, key) => {
        if (value) url.searchParams.set(key, value);
        else url.searchParams.delete(key);
    });

    fetch(url.toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('messages-container').innerHTML = html;
    });
});
</script>
@endpush
