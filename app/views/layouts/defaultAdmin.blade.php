<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Painel Titãs - {{{ Session::get('user.username') }}}</title>

        {{ HTML::style('static/css/dist/bootstrap.min.css') }}
        {{ HTML::style('static/css/defaults/defaultAdmin.css') }}
        {{ HTML::style('static/css/inputs.css') }}
        {{ HTML::style('http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900') }}
        @yield('styles')

        {{ HTML::script('static/js/jquery-1.11.1.min.js') }}
        {{ HTML::script('static/js/defaultAdmin.js') }}
        {{ HTML::script('static/js/wmmodal.js') }}
        @yield('scripts')
    </head>
    <body>

        <div class='header'>
            @yield('header')
        </div><!-- .header -->

        <div class='content'>
            <div class='sidebar-admin'>
                <div class='sidebar-admin-content'>@yield('sidebar')</div>
            </div><!-- .mercado -->
            <div class='menu'>
                <ul>
                    <li>{{ HTML::link('admin', 'Cadastrar Liga') }}</li>
                    <li>{{ HTML::link('admin/cadastrar-clube', 'Cadastrar Clube') }}</li>
                    <li>{{ HTML::link('admin/cadastrar-jogador', 'Cadastrar Jogador') }}</li>
                    <li>{{ HTML::link('#', 'Fórum') }}</li>
                </ul>
            </div><!-- .menu -->
            
            <div class='profile'>
                <a href='/logout' class='logout'>Sair</a>
                <a href='/user/account' class='account-link'>Minha conta</a>
                <h3>{{{ Session::get('user.username') }}}</h3>
                <img src="{{{ URL::to(Auth::user()->img_fullpath) }}}" width="104" height="104" />
            </div><!-- .profile -->

            @yield('content')

        </div><!-- .content -->

        <div class='footer'>
            @yield('footer')
        </div><!-- .footer -->

    </body>
</html>