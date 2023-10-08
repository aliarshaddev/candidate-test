<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 @include('layouts.head')
    <body class="font-sans antialiased">  
        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main>
              <div class="d-flex align-items-center justify-content-center">
                <div style="width: 30%;padding-top:10%">
                    @yield('content')
                </div>
            </div>
            </main>
        </div>
        @include('layouts.footer')
    </body>
</html>
