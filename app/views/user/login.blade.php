@extends("layouts.defaultGuest")

@section("styles")
    {{ HTML::style("static/css/login.css") }}
@stop

@section("content")

    <div id="box-login">
    {{ Form::open(["route" => "user/login", "autocomplete" => "off"]) }}

        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div><!-- .error -->
        @endif

        {{ Form::label("username", "Usuário:") }}
        {{ Form::text("username", Input::old("username"), [
            "class" => "",
            "placeholder" => "Usuário"
        ]) }}

        {{ Form::label("password", "Senha:") }}
        {{ Form::password("password", [
            "placeholder" => "Senha"
        ]) }}

        {{ Form::submit("Entrar") }}

    {{ Form::close() }}
    </div><!-- #box-login -->

@stop