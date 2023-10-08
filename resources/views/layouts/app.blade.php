<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 @include('layouts.head')
    <body class="font-sans antialiased">  
        @include('layouts.navbar')
        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main>
                <div class="container mt-3">
                    @yield('content')
                </div>
            </main>
        </div>
        @include('layouts.footer')
    </body>
</html>
