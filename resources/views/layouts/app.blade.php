<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
        @auth
            @if(Auth::user()->utype === 'ADM')
                @livewire('navigation-menu')
            @endif
        @endauth
            <!-- Page Heading -->
            
                    @if (isset($header))
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-row justify-between">
                                {{ $header }}
                                @auth
                                    @if(Auth::user()->utype === 'USR')
                                        <div class="flex flex-row">
                                            <a href="{{ url('/') }}" class="mr-6">
                                                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="" width="65" height="55">
                                            </a>

                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a> 
                                            <form id="logout-form" method="POST" action="{{route('logout')}}">
                                            @csrf 
                                            </form> 
                                            
                                        </div>
                                    @endif
                                @endauth  
                            </div>
                        </header>
                    @endif
                

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
