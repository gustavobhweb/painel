@extends("layouts.defaultGuest")

@section("styles")
    {{ HTML::style("static/css/login/loginSmall.css", [
        "media" => "screen and (min-width: 0px) and (max-width: 599px)"
    ]) }}
    {{ HTML::style("static/css/login/loginMedium.css", [
        "media" => "screen and (min-width: 600px) and (max-width: 999px)"
    ]) }}
    {{ HTML::style("static/css/login/loginLarge.css", [
        "media" => "screen and (min-width: 1000px)"
    ]) }}
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
            <div class="col-sm-10 input-login">
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
            <div class="col-sm-10 input-login">
                {{ Form::password("password", [
                    "class" => "txt-default txt-pass",
                    "required" => "required",
                    "placeholder" => "••••••••••••"
                ]) }}
            </div><!-- .col-sm-10 -->
        </div><!-- .form-group -->

        <div class="pull-left">
            {{ Form::label("ckb-connect", "Lembrar meu login", [
                "class" => "control-label pull-right",
                "style" => "margin:-6px 0 0 4px;font-size:13px"
            ]) }}
            {{ Form::checkbox("ckb-connect", "t", [
                "class" => "pull-left",
                "style" => "margin:10px 0 0 0"
            ]) }}
        </div>

        {{ Form::submit("Entrar", [
            "class" => "btn-panel-1 pull-right"
        ]) }}

    {{ Form::close() }}

    <div class="clearfix"></div>
    </div><!-- #box-login -->

@stop