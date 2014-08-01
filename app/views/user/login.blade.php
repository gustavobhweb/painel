@extends("layouts.defaultGuest")

@section("styles")
    {{ HTML::style("static/css/login.css") }}
@stop

@section("content")

    <div id="box-login">

    <h4>PAINEL TITÃS - SEJA BEM-VINDO</h4>

    {{ Form::open([
        "route" => "user/login",
        "autocomplete" => "off",
        "class" => "form-horizontal"
    ]) }}

        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div><!-- .error -->
        @endif

        <div class="form-group">
            {{ Form::label("username", "Usuário:", [
                "class" => "col-sm-2 control-label"
            ]) }}
            <div class="col-sm-10">
                {{ Form::text("username", Input::old("username"), [
                    "class" => "txt-default txt-email",
                    "required" => "required",
                    "placeholder" => "exemplo@email.com"
                ]) }}
            </div><!-- .col-sm-10 -->
        </div><!-- .form-group -->

        <div class="form-group">
            {{ Form::label("password", "Senha:", [
                "class" => "col-sm-2 control-label"
            ]) }}
            <div class="col-sm-10">
                {{ Form::password("password", [
                    "class" => "txt-default txt-pass",
                    "required" => "required",
                    "placeholder" => "♥ ♦ ♣ ♠ ♥ ♦ ♣ ♠"
                ]) }}
            </div><!-- .col-sm-10 -->
        </div><!-- .form-group -->

        {{ Form::submit("Entrar", [
            "class" => "btn-panel-1 pull-right"
        ]) }}

    {{ Form::close() }}

    <div class="clearfix"></div>
    </div><!-- #box-login -->

@stop