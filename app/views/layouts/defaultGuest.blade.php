<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Painel Titãs</title>

        {{ HTML::style('static/css/dist/bootstrap.min.css') }}
        {{ HTML::style('static/css/defaultGuest.css') }}
        {{ HTML::style('static/css/inputs.css') }}
        @yield('styles')

        {{ HTML::script('static/js/jquery-1.11.1.min.js') }}
        {{ HTML::script('static/js/defaultGuest.js') }}
        @yield('scripts')
    </head>
    <body>

        <div class='header'>
            @yield('header')
        </div><!-- .header -->

        <div class='content'>
            @yield('content')
        </div><!-- .content -->

        <div class='footer'>
            @yield('footer')
        </div><!-- .footer -->

    </body>
</html>