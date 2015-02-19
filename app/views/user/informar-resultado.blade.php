@extends('layouts.defaultAuth')


@section('content')

<?php $errors->setFormat('<div class="error">:message</div>'); ?>
<section class="wm-smooth-box">
    {{ Form::open() }}

        <h3>Registrar Partida</h3>
        <div class="inputs-container">

        {{ Form::label('liga_id', 'Selecione a Liga') }}

        {{ 
            Form::select(
                'liga_id',
                ['' => '(selecione)'] + $ligas,
                Input::old('liga_id'),
                [
                    'class'    => 'txt-default',
                    'required' => 'required'
                ]
            ) 
        }}

        </div>

        <div class="inputs-container">
            <label>Selecione o adversário</label>
        
            {{ 
                Form::text(
                    'adversario',
                    Input::old('adversario'),
                    [
                        'class' => 'txt-default',
                        'id'    => 'selecionar-adversario',
                        'placeholder' => 'Digite o nome do adversário'
                    ]
                ) 
            }}

            {{ 
                Form::hidden(
                    'adversario_id',
                    Input::old('adversario_id'),
                    ['id' => 'adversario-id']
                ) 
            }}

            {{ $errors->first('adversario_id') }}
        </div>

        <div>
            <div class="inputs-container">

            {{ Form::label('local_jogo', 'Você jogou onde?') }}
            
            {{ 
                Form::radio(
                    'local_jogo',
                    'fora',
                    null,
                    [
                        'required' => 'required',
                        'id' => 'local-jogo-fora'
                    ]
                ) 
            }}

            Fora

            {{ 
                Form::radio(
                    'local_jogo',
                    'casa',
                    null,
                    [
                        'required' => 'required',
                        'id'       => 'local-jogo-casa'
                    ]
                ) 
            }}

            Casa
            </div>
        </div>

        <div class='clearfix'>

            <div class='inputs-container medium'>
            {{ Form::label('gols_casa', 'Gols Casa') }}
            {{ 
                Form::number(
                    'gols_casa',
                    Input::old('gols_casa'),
                    ['class' => 'txt-default', 'min' => 0]
                )
            }}
            </div>
            <div class='inputs-container medium'>
            {{ Form::label('gols_fora', 'Gols Fora') }}
            {{ 
                Form::number(
                    'gols_fora',
                    Input::old('gols_fora'),
                    ['class' => 'txt-default', 'min' => 0]
                )
            }}
            </div>
        </div>

        <div class="inputs-container">
            
            {{ Form::submit('Salvar', ['class' => 'btn btn-black']) }}
        </div>

    {{ Form::close() }}
</section>

@stop


@section('scripts')
{{ 
    HTML::script('static/js/jquery-ui.js'),
    HTML::script('static/js/user/informar_resultado.js')
}}
@append


@section('styles')
{{ HTML::style('static/css/jquery-ui.min.css') }}
@append