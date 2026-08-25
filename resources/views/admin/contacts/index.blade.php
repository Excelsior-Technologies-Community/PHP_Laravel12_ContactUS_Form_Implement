@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto mt-10 px-4">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                Customer Messages
            </h2>

            <p class="text-gray-500 mt-1">
                Manage and respond to customer inquiries
            </p>
        </div>

        <div class="flex flex-wrap gap-3">

            <a
                href="{{ route('dashboard') }}"
                class="bg-gray-800 text-white px-5 py-3 rounded-xl hover:bg-gray-900 transition font-medium">
                Dashboard
            </a>

            {{-- CSV EXPORT --}}
            <a
                href="{{ route('admin.contacts.export', request()->query()) }}"
                class="bg-green-600 text-white px-5 py-3 rounded-xl hover:bg-green-700 transition font-medium">
                Export CSV
            </a>

        </div>

    </div>


    {{-- FILTERS --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-5 mb-6">

        <form
            id="filter-form"
            method="GET"
            action="{{ route('admin.contacts') }}"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8 gap-3">

            {{-- SEARCH --}}
            <div class="xl:col-span-2">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search messages..."
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

            </div>


            {{-- PRIORITY --}}
            <select
                name="priority"
                class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

                <option value="">
                    All Priorities
                </option>

                <option
                    value="low"
                    {{ request('priority') == 'low' ? 'selected' : '' }}>
                    Low
                </option>

                <option
                    value="medium"
                    {{ request('priority') == 'medium' ? 'selected' : '' }}>
                    Medium
                </option>

                <option
                    value="high"
                    {{ request('priority') == 'high' ? 'selected' : '' }}>
                    High
                </option>

                <option
                    value="urgent"
                    {{ request('priority') == 'urgent' ? 'selected' : '' }}>
                    Urgent
                </option>

            </select>


            {{-- STATUS --}}
            <select
                name="status"
                class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

                <option value="">
                    All Status
                </option>

                <option
                    value="new"
                    {{ request('status') == 'new' ? 'selected' : '' }}>
                    New
                </option>

                <option
                    value="read"
                    {{ request('status') == 'read' ? 'selected' : '' }}>
                    Read
                </option>

                <option
                    value="replied"
                    {{ request('status') == 'replied' ? 'selected' : '' }}>
                    Replied
                </option>

                <option
                    value="closed"
                    {{ request('status') == 'closed' ? 'selected' : '' }}>
                    Closed
                </option>

            </select>


            {{-- FROM DATE --}}
            <input
                type="date"
                name="from_date"
                value="{{ request('from_date') }}"
                class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">


            {{-- TO DATE --}}
            <input
                type="date"
                name="to_date"
                value="{{ request('to_date') }}"
                class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">


            {{-- SORT --}}
            <select
                name="sort"
                class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

                <option
                    value="latest"
                    {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                    Latest First
                </option>

                <option
                    value="oldest"
                    {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                    Oldest First
                </option>

                <option
                    value="name_asc"
                    {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                    Name A-Z
                </option>

                <option
                    value="name_desc"
                    {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                    Name Z-A
                </option>

                <option
                    value="priority"
                    {{ request('sort') == 'priority' ? 'selected' : '' }}>
                    Priority
                </option>

            </select>


            {{-- PER PAGE --}}
            <select
                name="per_page"
                class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

                <option
                    value="6"
                    {{ request('per_page', 6) == 6 ? 'selected' : '' }}>
                    6 / Page
                </option>

                <option
                    value="10"
                    {{ request('per_page') == 10 ? 'selected' : '' }}>
                    10 / Page
                </option>

                <option
                    value="20"
                    {{ request('per_page') == 20 ? 'selected' : '' }}>
                    20 / Page
                </option>

                <option
                    value="50"
                    {{ request('per_page') == 50 ? 'selected' : '' }}>
                    50 / Page
                </option>

            </select>


            {{-- BUTTONS --}}
            <div class="flex gap-2">

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    Filter
                </button>

                <a
                    href="{{ route('admin.contacts') }}"
                    class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 transition">
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- BULK DELETE --}}
    <form
        id="bulk-delete-form"
        action="{{ route('admin.contacts.bulk-delete') }}"
        method="POST">

        @csrf

        @method('DELETE')


        {{-- BULK TOOLBAR --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-4">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div class="flex items-center gap-3">

                    <label class="flex items-center gap-2 cursor-pointer">

                        <input
                            type="checkbox"
                            id="select-all"
                            class="w-4 h-4 text-blue-600 rounded">

                        <span class="text-sm text-gray-600">
                            Select All
                        </span>

                    </label>

                    <span
                        id="selected-count"
                        class="text-sm font-medium text-blue-600">
                        0 selected
                    </span>

                </div>


                <button
                    type="submit"
                    id="bulk-delete-button"
                    disabled
                    class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                    Delete Selected
                </button>

            </div>

        </div>


        {{-- TABLE --}}
        <div id="messages-container">

            @include('admin.contacts.partials.table')

        </div>

    </form>

</div>

@endsection


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const filterForm = document.getElementById('filter-form');

        const messagesContainer =
            document.getElementById('messages-container');

        const selectAll =
            document.getElementById('select-all');

        const selectedCount =
            document.getElementById('selected-count');

        const deleteButton =
            document.getElementById('bulk-delete-button');

        /*
        |--------------------------------------------------------------------------
        | Update Selected Count
        |--------------------------------------------------------------------------
        */

        function updateSelectedCount() {

            const checkboxes =
                document.querySelectorAll('.message-checkbox:checked');

            const count = checkboxes.length;

            selectedCount.textContent =
                count + ' selected';

            deleteButton.disabled =
                count === 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Select All
        |--------------------------------------------------------------------------
        */

        selectAll.addEventListener('change', function() {

            const checkboxes =
                document.querySelectorAll('.message-checkbox');

            checkboxes.forEach(function(checkbox) {

                checkbox.checked =
                    selectAll.checked;

            });

            updateSelectedCount();

        });


        /*
        |--------------------------------------------------------------------------
        | Individual Checkbox
        |--------------------------------------------------------------------------
        */

        document.addEventListener('change', function(event) {

            if (
                event.target.classList.contains(
                    'message-checkbox'
                )
            ) {

                updateSelectedCount();

            }

        });


        /*
        |--------------------------------------------------------------------------
        | Filter AJAX
        |--------------------------------------------------------------------------
        */

        filterForm.addEventListener('submit', function(e) {

            e.preventDefault();

            const formData =
                new FormData(filterForm);

            const url =
                new URL(
                    filterForm.action,
                    window.location.origin
                );

            formData.forEach(function(value, key) {

                if (value) {

                    url.searchParams.set(
                        key,
                        value
                    );

                }

            });


            fetch(
                    url.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                )

                .then(response => response.text())

                .then(html => {

                    messagesContainer.innerHTML =
                        html;

                    selectAll.checked =
                        false;

                    updateSelectedCount();

                    window.history.pushState({},
                        '',
                        url.toString()
                    );

                })

                .catch(error => {

                    console.error(
                        'Filter error:',
                        error
                    );

                });

        });


        /*
        |--------------------------------------------------------------------------
        | Bulk Delete Confirmation
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('bulk-delete-form')
            .addEventListener('submit', function(e) {

                const count =
                    document.querySelectorAll(
                        '.message-checkbox:checked'
                    ).length;

                if (count === 0) {

                    e.preventDefault();

                    return;

                }

                const confirmed =
                    confirm(
                        `Are you sure you want to delete ${count} message(s)?`
                    );

                if (!confirmed) {

                    e.preventDefault();

                }

            });

    });
</script>

@endpush