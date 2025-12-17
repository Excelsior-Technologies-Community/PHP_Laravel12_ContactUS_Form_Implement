# Laravel 12 Contact Us Form with Admin Panel (Laravel Breeze Authentication)




---

## STEP 1: Install Laravel 12 

If Laravel 12 is not installed, run:

```bash
composer create-project laravel/laravel PHP_Laravel12_ContactUS_Form_Implement
```

---

## STEP 2: Database Configuration

Open `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Your database name
DB_USERNAME=root
DB_PASSWORD=root
```

Explanation:  
Connects Laravel application with MySQL database.

---

## STEP 3: Create Migration (Contact Messages Table)

```bash
php artisan make:migration create_contact_messages_table --create=contact_messages
```

```php
Schema::create('contact_messages', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('last_name');
    $table->string('email');
    $table->string('mobile');
    $table->text('message');
    $table->timestamps();
});
```

Run migration:

```bash
php artisan migrate
```

---

## STEP 4: Create Model

```bash
php artisan make:model ContactMessage
```

```php
class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'mobile',
        'message',
    ];
}
```

---

## STEP 5: Routes

`routes/web.php`

```php
use App\Http\Controllers\ContactController;

Route::get('/contact', [ContactController::class, 'index'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/admin/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts');

require __DIR__.'/auth.php';
```

---

## STEP 6: ContactController

`app/Http/Controllers/ContactController.php`

```php
class ContactController extends Controller
{
    public function index()
    {
        return view('customer.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required','regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required','regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'mobile' => ['required','digits:10'],
            'message' => ['required','min:5'],
        ]);

        ContactMessage::create($request->all());

        return redirect()->back()->with('success','Message sent successfully!');
    }

    public function adminIndex(Request $request)
    {
        $messages = ContactMessage::latest()->paginate(4);
        return view('admin.contacts.index', compact('messages'));
    }
}
```

---

## STEP 7: Customer blade file create Contact View

`resources/views/customer/contact.blade.php`

```blade
@extends('layouts.customer')

@section('content')
<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">

@if(session('success'))
<div style="background-color:lightgreen;padding:20px;border-radius:6px;">
{{ session('success') }}
</div>
@endif

<form action="{{ route('contact.store') }}" method="POST">
@csrf

<input type="text" name="name" placeholder="Name" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')" class="w-full border p-2 mb-2">

<input type="text" name="last_name" placeholder="Last Name" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')" class="w-full border p-2 mb-2">

<input type="email" name="email" placeholder="example@gmail.com" class="w-full border p-2 mb-2">

<input type="text" name="mobile" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')" class="w-full border p-2 mb-2">

<textarea name="message" class="w-full border p-2 mb-2"></textarea>

<button class="bg-blue-600 text-white px-4 py-2 rounded">Send</button>
</form>
</div>
@endsection
```

---

## STEP 8: Admin create blade file for list all the data 

`resources/views/admin/contacts/index.blade.php`

```blade
@extends('layouts.admin')

@section('content')
<table border="1" width="100%">
<tr>
<th>Name</th><th>Email</th><th>Mobile</th><th>Message</th><th>Date</th>
</tr>
@foreach($messages as $msg)
<tr>
<td>{{ $msg->name }}</td>
<td>{{ $msg->email }}</td>
<td>{{ $msg->mobile }}</td>
<td>{{ $msg->message }}</td>
<td>{{ $msg->created_at }}</td>
</tr>
@endforeach
</table>

{{ $messages->links() }}
@endsection
```

---

## STEP 9: create admin and customer Layout Files

### Admin Layout  
`resources/views/layouts/admin.blade.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    @include('layouts.admin-navbar')  <!-- sirf admin ke liye navbar -->
    <div class="py-6">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>
</html>

```

### Customer Layout  
`resources/views/layouts/customer.blade.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <div class="py-6">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>
</html>

```
# Update navbar.blade.php and admin-navbarblade.php
---
`resources/views/layouts/navbar.blade.php`
---
```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    @include('layouts.admin-navbar')  <!-- sirf admin ke liye navbar -->
    <div class="py-6">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>
</html>
```

---
`resources/views/layouts/admin-navbar.blade.php`
---
---
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.contacts')" :active="request()->routeIs('admin.contacts')">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if(Auth::check())
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>


---
---

## STEP 10: Install Laravel Breeze for admin login and registration (Existing Project)

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run build
php artisan migrate
```

---

## STEP 11: Run Project

```bash
php artisan serve
```

Visit:
- http://127.0.0.1:8000/contact

  <img width="979" height="362" alt="image" src="https://github.com/user-attachments/assets/008677f1-674b-4269-a906-2a944e2000ed" />

- http://127.0.0.1:8000/admin/contacts

<img width="355" height="378" alt="image" src="https://github.com/user-attachments/assets/c92c60f2-2b60-486f-abd7-58e7a09af6dd" />


<img width="377" height="295" alt="image" src="https://github.com/user-attachments/assets/0b2a0745-786c-429d-bdc9-0752509dd77e" />


<img width="628" height="201" alt="image" src="https://github.com/user-attachments/assets/8814acec-2fb6-4378-b554-f18c1bb1e8ad" />


---

 

---

