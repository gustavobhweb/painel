<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>{{ Auth::user()->nome }}</title>

        {{ HTML::style('static/css/dist/bootstrap.min.css') }}
        {{ HTML::style('static/css/defaultAuth.css') }}
        {{ HTML::style('static/css/inputs.css') }}
        @yield('styles')

        {{ HTML::script('static/js/jquery-1.11.1.min.js') }}
        {{ HTML::script('static/js/defaultAuth.js') }}
        @yield('scripts')
    </head>
    <body>

        <div class='header'>
            <p class='pull-left'>{{ Auth::user()->nome }}, seja bem-vindo</p>
            <a class='pull-right btn btn-danger' href="{{ URL::route('user/logout') }}"><i class="glyphicon glyphicon-remove"></i> Sair</a>
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