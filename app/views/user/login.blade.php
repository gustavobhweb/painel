@extends("layouts.default")

@section("content")
    {{ Form::open(["route" => "user/login", "autocomplete" => "off"]) }}

        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div><!-- .error -->
        @endif

        {{ Form::label("username", "Usuário:") }}
        {{ Form::text("username", Input::old("username"), [
            "placeholder" => "Usuário"
        ]) }}

        {{ Form::label("password", "Senha:") }}
        {{ Form::password("password", [
            "placeholder" => "Senha"
        ]) }}

        {{ Form::submit("Entrar") }}

    {{ Form::close() }}
@stop