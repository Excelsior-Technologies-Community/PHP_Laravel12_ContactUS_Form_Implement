<div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">

    @if($messages->count())

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="px-6 py-4 text-left">

                        <span class="text-xs font-semibold text-gray-500 uppercase">
                            Select
                        </span>

                    </th>

                    <th class="px-6 py-4 text-left">

                        <span class="text-xs font-semibold text-gray-500 uppercase">
                            Customer
                        </span>

                    </th>

                    <th class="px-6 py-4 text-left">

                        <span class="text-xs font-semibold text-gray-500 uppercase">
                            Email
                        </span>

                    </th>

                    <th class="px-6 py-4 text-left">

                        <span class="text-xs font-semibold text-gray-500 uppercase">
                            Priority
                        </span>

                    </th>

                    <th class="px-6 py-4 text-left">

                        <span class="text-xs font-semibold text-gray-500 uppercase">
                            Status
                        </span>

                    </th>

                    <th class="px-6 py-4 text-left">

                        <span class="text-xs font-semibold text-gray-500 uppercase">
                            Date
                        </span>

                    </th>

                    <th class="px-6 py-4 text-right">

                        <span class="text-xs font-semibold text-gray-500 uppercase">
                            Action
                        </span>

                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @foreach($messages as $message)

                <tr class="hover:bg-gray-50 transition">

                    {{-- CHECKBOX --}}
                    <td class="px-6 py-4">

                        <input
                            type="checkbox"
                            name="ids[]"
                            value="{{ $message->id }}"
                            class="message-checkbox w-4 h-4 text-blue-600 rounded">

                    </td>


                    {{-- CUSTOMER --}}
                    <td class="px-6 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                {{ strtoupper(substr($message->name, 0, 1)) }}
                            </div>

                            <div>

                                <p class="font-semibold text-gray-800">

                                    {{ $message->name }}
                                    {{ $message->last_name }}

                                </p>

                                @if($message->subject)

                                <p class="text-xs text-gray-400">
                                    {{ $message->subject }}
                                </p>

                                @endif

                            </div>

                        </div>

                    </td>


                    {{-- EMAIL --}}
                    <td class="px-6 py-4">

                        <span class="text-sm text-gray-600">

                            {{ $message->email }}

                        </span>

                    </td>


                    {{-- PRIORITY --}}
                    <td class="px-6 py-4">

                        <span
                            class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                    @if($message->priority === 'low')
                                        bg-green-100 text-green-700
                                    @elseif($message->priority === 'medium')
                                        bg-yellow-100 text-yellow-700
                                    @elseif($message->priority === 'high')
                                        bg-orange-100 text-orange-700
                                    @else
                                        bg-red-100 text-red-700
                                    @endif">

                            {{ ucfirst($message->priority) }}

                        </span>

                    </td>


                    {{-- STATUS --}}
                    <td class="px-6 py-4">

                        <span
                            class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                    @if($message->status === 'new')
                                        bg-blue-100 text-blue-700
                                    @elseif($message->status === 'read')
                                        bg-yellow-100 text-yellow-700
                                    @elseif($message->status === 'replied')
                                        bg-green-100 text-green-700
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif">

                            {{ ucfirst($message->status) }}

                        </span>

                    </td>


                    {{-- DATE --}}
                    <td class="px-6 py-4">

                        <span class="text-sm text-gray-500">

                            {{ $message->created_at->format('d M Y') }}

                        </span>

                    </td>


                    {{-- ACTION --}}
                    <td class="px-6 py-4 text-right">

                        <a
                            href="{{ route('admin.contacts.show', $message) }}"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">

                            View

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>


    {{-- PAGINATION --}}

    <div class="px-6 py-5 border-t border-gray-100">

        {{ $messages->links() }}

    </div>

    @else

    <div class="py-16 text-center">

        <div
            class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">

            <svg
                class="w-8 h-8 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 012 2h-5l-5 5v-5z" />

            </svg>

        </div>

        <h3 class="text-lg font-semibold text-gray-700">
            No messages found
        </h3>

        <p class="text-gray-400 mt-1">
            Try changing your search or filters.
        </p>

    </div>

    @endif

</div>