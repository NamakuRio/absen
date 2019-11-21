<!DOCTYPE html>
<html lang="id">
    <head>
        @include('templates._partials._head')
        @include('templates._partials._styles')
    </head>
    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
                <div class="navbar-bg"></div>
                @include('templates._partials._navbar')
                @include('templates._partials._sidebar')
                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                        @yield('content')
                    </section>
                    @include('templates.components.modals')
                </div>
                @include('templates._partials._footer')
            </div>
        </div>
        @include('templates._partials._scripts')
    </body>
</html>
