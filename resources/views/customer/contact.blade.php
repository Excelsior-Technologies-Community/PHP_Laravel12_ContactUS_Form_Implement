@extends('layouts.customer')

@section('content')
<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">

    {{-- ✅ SUCCESS MESSAGE --}}
  @if(session('success'))
    <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 mb-4 rounded flex items-center gap-2" style="background-color: lightgreen; padding: 20px;">
        
        {{ session('success') }}
    </div>
@endif


    <form action="{{ route('contact.store') }}" method="POST">
        @csrf

        {{-- NAME --}}
        <div class="mb-4">
            <label class="font-medium">Name</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter first name"
                oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')"
                class="w-full border p-2 rounded"
            >
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- LAST NAME --}}
        <div class="mb-4">
            <label class="font-medium">Last Name</label>
            <input
                type="text"
                name="last_name"
                value="{{ old('last_name') }}"
                placeholder="Enter last name"
                oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')"
                class="w-full border p-2 rounded"
            >
            @error('last_name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div class="mb-4">
            <label class="font-medium">Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="example@gmail.com"
                class="w-full border p-2 rounded"
            >
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- MOBILE --}}
        <div class="mb-4">
            <label class="font-medium">Mobile</label>
            <input
                type="text"
                name="mobile"
                value="{{ old('mobile') }}"
                maxlength="10"
                placeholder="10 digit mobile number"
                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                class="w-full border p-2 rounded"
            >
            @error('mobile')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- MESSAGE --}}
        <div class="mb-4">
            <label class="font-medium">Message</label>
            <textarea
                name="message"
                rows="4"
                placeholder="Write your message..."
                class="w-full border p-2 rounded"
            >{{ old('message') }}</textarea>
            @error('message')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- SUBMIT --}}
        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded"
        >
            Send Message
        </button>

    </form>
</div>
@endsection
