<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="cashier-bg">
        <!-- <div wire:offline.class="bg-red-300">
            You are now offline.
        </div> 
        
        bring this back later

        -->




        {{-- Error messages 
        <!-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> -->
       
        @endif--}}


        {{-- Page header (optional, only shows when $header slot is used) --}}
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        {{-- Page Content --}}
        <main>
            {{ $slot }}
        </main>

        {{-- ============================================================
             FOOTER NAVIGATION
             Replaces @livewire('navigation-menu')

             Route names used below — make sure these exist in web.php:
               route('cashier')          → Cashier / POS view
               route('stock')            → Current Stock view
               route('receiving-stock')  → Receiving Stock view

             METHOD needed in your Livewire component:
               logout()  →  Auth::logout(); redirect()->route('login');
             ============================================================ --}}
        <div class="footer-navigation">

            <a href="{{ route('cashier-view') }}" class="footer-nav-link">Cashier</a>
            <a href="{{ route('current_stock') }}" class="footer-nav-link">Current Stock</a>
            <a href="{{ route('receiving_stock') }}" class="footer-nav-link">Receiving Stock</a>

            {{-- Sign Out — submits to Laravel's built-in logout route --}}
            <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0;">
                @csrf
                <button type="submit" class="footer-nav-link">Sign Out</button>
            </form>

        </div>

    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>