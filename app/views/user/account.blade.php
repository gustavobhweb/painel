@extends('layouts.defaultAuth')

@section('styles')
	{{ HTML::style('static/css/account.css') }}
	{{ HTML::style('static/css/crop.css') }}
	{{ HTML::style('static/css/imgSelect.css') }}
@stop

@section('scripts')
	{{ HTML::script('static/js/crop.js') }}
	{{ HTML::script('static/js/jcrop.js') }}
	{{ HTML::script('static/js/account.js') }}
	{{ HTML::script('static/js/imgSelect.min.js') }}
	{{ HTML::script('static/js/jcam.js') }}
@stop

@section('content')
	<div class='account'>

		<div class='account-options'>
			<h4>Configurações de conta</h4>
			<div class='left'>
				<img src='{{{ URL::to(Auth::user()->img_fullpath) }}}' width='170' />
				<button class='btn btn-default btn-xs btn-select-image'><i class='glyphicon glyphicon-picture'></i> Selecionar imagem...</button>
				<button class='btn btn-default btn-xs btn-open-webcam' onclick='$(".imgs-webcam").click()'><i class='glyphicon glyphicon-camera'></i> Tirar foto pela webcam</button>
			</div><!-- .left -->
			<div class='right'>
				<form name='frm-change-name' class='form-inline'>
					<div class='form-group'>
						<input type='text' class='form-control input-sm' id='-nome' value='{{{ Auth::user()->nome }}}' placeholder='Insira seu nome aqui' />
						<button type='button' class='btn btn-primary btn-sm btn-save-change-name'>Salvar</button>
					</div><!-- .form-group -->
				</form>
				<div class='group-btn-account'>
					<button class='btn btn-primary btn-sm btn-email'><i class='glyphicon glyphicon-envelope'></i> Trocar e-mail</button>
					<button class='btn btn-primary btn-sm btn-senha'><i class='glyphicon glyphicon-pencil'></i> Trocar senha</button>
				</div><!-- .group-btn-account -->
				<form id='frm-change-mail'>
					<div class='form-group'>
						<label for='change-mail-pass'>Insira sua senha:</label>
						<input type='password' class='form-control' name='change-mail-pass' id='change-mail-pass' />
					</div><!-- .form-group -->
					<div class='form-group'>
						<label for='change-mail-mail'>Insira o novo e-mail:</label>
						<input type='text' class='form-control' name='change-mail-mail' id='change-mail-mail' />
					</div><!-- .form-group -->
					<div class='form-group'>
						<label for='change-mail-conf-mail'>Confirme o novo e-mail:</label>
						<input type='text' class='form-control' name='change-mail-conf-mail' id='change-mail-conf-mail' />
					</div><!-- .form-group -->
					<button type='button' class='btn btn-danger btn-sm btn-cancel-change-mail'>Cancelar</button>
					<button type='button' class='btn btn-primary btn-sm btn-save-change-mail'><i class='glyphicon glyphicon-ok'></i> Salvar</button>
				</form>
				<form id='frm-change-pass'>
					<div class='form-group'>
						<label for='change-pass-pass'>Insira sua senha atual:</label>
						<input type='password' class='form-control' name='change-pass-pass' id='change-pass-pass' />
					</div><!-- .form-group -->
					<div class='form-group'>
						<label for='change-pass-new-pass'>Insira a nova senha:</label>
						<input type='password' class='form-control' name='change-pass-new-pass' id='change-pass-new-pass' />
					</div><!-- .form-group -->
					<div class='form-group'>
						<label for='change-pass-conf-pass'>Confirme a nova senha:</label>
						<input type='password' class='form-control' name='change-pass-conf-pass' id='change-pass-conf-pass' />
					</div><!-- .form-group -->
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<button type='button' class='btn btn-danger btn-sm btn-cancel-change-pass'>Cancelar</button>
					<button type='button' class='btn btn-primary btn-sm btn-save-change-pass'><i class='glyphicon glyphicon-ok'></i> Salvar</button>
				</form>
			</div><!-- .right -->
			<a href='{{{ URL::to("home") }}}' class='close-account'></a>
		</div><!-- .account-options -->

		<div class='crop-image'>
			<input type='file' id='file' />
			<div class='crop'><p style='color:white;text-align:center;padding:0 0 10px 0;font:20px Roboto;font-weight:300'>Aguarde...</p></div>
		</div><!-- .crop-image -->

		<div class='webcam-capture'>
			<div id="imgselect_container">
		        <button type="button" class="btn btn-success imgs-webcam hide">Webcam</button>

				<div class="imgs-webcam-container"></div>
				
				<!-- Action buttons -->
				<button type="button" class="btn btn-primary imgs-capture">Capture</button> <!-- .imgs-capture -->
				<button type="button" class="btn btn-default imgs-cancel hide">Cancel</button> <!-- .imgs-cancel -->
				<button class="btn btn-cancel btn-back-account-options" onclick="$('.imgs-cancel').click()">Voltar</button>

				<div class="imgs-alert alert"></div> <!-- .imgs-alert -->
	        </div>
		</div><!-- .webcam-capture -->
	</div><!-- .account -->
@stop