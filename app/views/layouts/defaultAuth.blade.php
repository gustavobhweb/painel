<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Painel Titãs - {{ Auth::user()->username }}</title>

        {{ HTML::style('static/css/dist/bootstrap.min.css') }}
        {{ HTML::style('static/css/defaults/defaultAuth.css') }}
        {{ HTML::style('static/css/inputs.css') }}
        {{ HTML::style('http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900') }}
        @yield('styles')

        {{ HTML::script('static/js/jquery-1.11.1.min.js') }}
        {{ HTML::script('static/js/underscore.js') }}
        {{ HTML::script('static/js/defaultAuth.js') }}
        {{ HTML::script('static/js/wmmodal.js') }}
        @yield('scripts')
    </head>
    <body>

        <div class='header'>
            <!-- <p class='pull-left'>{{ Auth::user()->nome }}, seja bem-vindo</p>
            <a class='pull-right btn btn-danger' href="{{ URL::route('user/logout') }}"><i class="glyphicon glyphicon-remove"></i> Sair</a> -->
            @yield('header')
        </div><!-- .header -->

        <div class='content'>
            <div class='mercado'>
                <a href="#"><div class='title-img'></div></a>
                <div class='mercado-content'></div>
            </div><!-- .mercado -->
            <div class='menu'>
                <ul>
                    <li><a href='#'>Classificação</a></li>
                    <li><a href='#'>Artilharia</a></li>
                    <li><a href='#'>Estatística</a></li>
                    <li><a href='#'>Noticiário</a></li>
                    <li><a href='{{ URL::to('user/ligas') }}'>Torneio/Copa</a></li>
                    <li><a href='#'>Fórum</a></li>
                </ul>
            </div><!-- .menu -->
            
            <div class='profile'>
                <a href='/logout' class='logout'>Sair</a>
                <a href='/user/account' class='account-link'>Minha conta</a>
                <h3>{{{ Auth::user()->username }}}</h3>
                <img src="{{{ URL::to(Auth::user()->img_fullpath) }}}" width="104" height="104" />
                <div class='money'>
                    <p>Salário atual 11.100,00</p>
                    <p>Salários a pagar 11.100,00</p>
                    <h4>Saldo Draft 7.300,00</h4>
                </div><!-- .money -->
            </div><!-- .profile -->

            <section class="yield-content">@yield('content')</section>

        </div><!-- .content -->

        <div class='footer'>
            @yield('footer')
        </div><!-- .footer -->

    </body>
</html>