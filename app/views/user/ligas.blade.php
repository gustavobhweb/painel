@extends('layouts.defaultAuth')


@section('content')
<div class="col-xs-5 wm-smooth-box">
    <h3>Ligas</h3>
    <ul class="list-group">
    @foreach($ligas as $liga)
        <li class="list-group-item smooth-color">
            <a title="participar?" href="{{ URL::action('UserController@anyParticiparLiga', [$liga->id]) }}">
                {{{ $liga->nome }}}
            </a>
            <div class="pull-right">
                <button data-object="{{{ $liga }}}" class="btn btn-primary btn-modal-info">
                    <span class="glyphicon glyphicon-info-sign"></span>
                </button>
            </div>
            <div class="clearfix"></div>
        </li>
    @endforeach
    </ul>
</div>


<script id="tpl-modal-info" type="text/template">
<div id="box-liga-info">
    <div id="img-container">
        <img src="{{ URL::to('ligas') }}/<%= logo %>" height="100" width="100">
    </div>
    <div id="info-container"><%- info %></div>
</div>
</script>

@stop


@section('scripts')
{{ HTML::script('static/js/user/ligas.js') }}
@stop

@section('styles')
{{ HTML::style('static/css/user/ligas.css') }}
@stop