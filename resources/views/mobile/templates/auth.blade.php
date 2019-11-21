<!DOCTYPE html>
<html lang="id">
    <head>
        @include('templates._partials._head')
        @include('templates._partials._styles')
    </head>
    <body>
        <div id="app">
            <section class="section">
                @yield('content')
            </section>
        </div>
        @include('templates._partials._scripts')
    </body>
</html>
