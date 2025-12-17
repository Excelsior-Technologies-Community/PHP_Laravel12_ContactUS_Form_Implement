@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto mt-10">

    {{-- PAGE TITLE --}}
    <h2 class="text-2xl font-bold mb-4">Customer Messages</h2>

    {{-- 🔍 SEARCH FORM --}}
    <form method="GET" action="{{ route('admin.contacts') }}" class="mb-6">
        <div class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search name, email or message..."
                class="border px-3 py-2 rounded w-72"
            >

            <button type="submit" class="bg-black text-white px-4 py-2 rounded">
                Search
            </button>
        </div>
    </form>

    {{-- TABLE --}}
    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Last Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Mobile</th>
                <th class="border px-4 py-2">Message</th>
                <th class="border px-4 py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $msg)
                <tr>
                    <td class="border px-4 py-2">{{ $msg->name }}</td>
                    <td class="border px-4 py-2">{{ $msg->last_name }}</td>
                    <td class="border px-4 py-2">{{ $msg->email }}</td>
                    <td class="border px-4 py-2">{{ $msg->mobile }}</td>
                    <td class="border px-4 py-2">{{ $msg->message }}</td>
                    <td class="border px-4 py-2">
                        {{ $msg->created_at->format('d-m-Y H:i') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border px-4 py-3 text-center text-gray-500">
                        No messages found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- 📄 PAGINATION --}}
    <div class="mt-6">
        {{ $messages->links() }}
    </div>

</div>
@endsection
