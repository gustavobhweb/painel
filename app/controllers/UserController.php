<?php

use Illuminate\Support\MessageBag;

class UserController extends Controller {

    public function loginAction()
    {
        $errors = new MessageBag();

        if ($old = Input::old("errors")) {
            $errors = $old;
        }

        $data = [
            "errors" => $errors
        ];


        if (Request::isMethod('post')) {
            $validator = Validator::make(Input::all(), [
                "username" => "required",
                "password" => "required"
            ]);

            if ($validator->passes()) {
                $credentials = [
                    "username" => Input::get("username"),
                    "password" => Input::get("password")
                ];

                if (Auth::attempt($credentials)) {
                	Session::put('user', Auth::user()->toArray());
                    return Redirect::route("user/home");
                }
            }

            $data["errors"] = new MessageBag([
                "password" => ["Usuário e/ou senha incorretos."]
            ]);

            $data["username"] = Input::get("username");

            return Redirect::route("user/login")->withInput($data);
        }

        return View::make("user/login", $data);
    }

    public function logoutAction()
    {
        Auth::logout();
        Session::flush();
        return Redirect::route("user/login");
    }

    public function homeAction()
    {   
        $viewVars['verificarParticipacao'] = LigaUsuarioClube::verificarParticipacao();
        return View::make('user/home', $viewVars);
    }

    public function anyAccount()
    {
        return View::make('user/account');
    }

    public function postAjaxChangeMail()
    {
        $data = [
            'pass' => Input::get('pass'),
            'mail' => Input::get('mail'),
            'confMail' => Input::get('confMail')
        ];

        if (!Hash::check($data['pass'], Auth::user()->password)) {
            return Response::json([
                'status' => false,
                'text' => 'A senha atual não confere.',
                'debug' => $data['pass']
            ]);
        } elseif (is_null($data['mail']) || is_null($data['confMail']) || $data['mail'] == '' || $data['confMail'] == '') {
            return Response::json([
                'status' => false,
                'text' => 'Complete todos os campos.'
            ]);
        } elseif(!User::isValidEmail($data['mail']) || !User::isValidEmail($data['confMail'])) {
            return Response::json([
                'status' => false,
                'text' => 'Insira um e-mail válido.'
            ]);
        } elseif ($data['mail'] != $data['confMail']) {
            return Response::json([
                'status' => false,
                'text' => 'Confirme o e-mail corretamente.'
            ]);
        } elseif (User::where('email', '=', $data['mail'])->count()) {
            return Response::json([
                'status' => false,
                'text' => 'Este e-mail já está cadastrado no sistema.'
            ]);
        } else {
            $user = User::where('id', '=', Auth::user()->id)->first();
            $user->email = $data['mail'];
            $user->save();

            return Response::json([
                'status' => true,
                'text' => 'E-mail alterado com sucesso.'
            ]);
        }
    }

    public function postAjaxChangePass()
    {
        $data = [
            'pass' => Input::get('pass'),
            'newPass' => Input::get('newPass'),
            'confPass' => Input::get('confPass')
        ];

        if (!Hash::check($data['pass'], Auth::user()->password)) {
            return Response::json([
                'status' => false,
                'text' => 'A senha atual não confere.',
                'debug' => $data['pass']
            ]);
        } elseif (is_null($data['newPass']) || is_null($data['confPass']) || $data['newPass'] == '' || $data['confPass'] == '') {
            return Response::json([
                'status' => false,
                'text' => 'Complete todos os campos.'
            ]);
        } elseif ($data['newPass'] != $data['confPass']) {
            return Response::json([
                'status' => false,
                'text' => 'Confirme a senha corretamente.'
            ]);
        } else {
            DB::table('usuarios')
                ->where('id', Auth::user()->id)
                ->update(['password' => Hash::make($data['newPass'])]);

            return Response::json([
                'status' => true,
                'text' => 'Senha alterada com sucesso.'
            ]);
        }
    }

    public function postAjaxChangeName()
    {
        $nome = Input::get('nome');

        if (is_null($nome) || $nome == '') {
            return Response::json([
                'status' => false,
                'text' => 'Você deve inserir um nome.'
            ]);
        } else {
            $user = User::where('id', '=', Auth::user()->id)->first();
            $user->nome = $nome;
            $user->save();

            return Response::json([
                'status' => true,
                'text' => 'Nome alterado com sucesso.'
            ]);
        }
    }

    public function postAjaxCropImage()
    {
        $x = Input::get('x');
        $y = Input::get('y');
        $w = Input::get('w');
        $h = Input::get('h');
        $image = Input::get('base64');

        if (file_exists(Auth::user()->img_fullpath)) unlink(Auth::user()->img_fullpath);

        $base64 = base64_decode($image);
        $im = imagecreatefromstring($base64);
        $ds = DIRECTORY_SEPARATOR;
        $fullpath = "users{$ds}profile{$ds}" . md5(uniqid(time())) . '.jpg';

        $dest = imagecreatetruecolor(300, 300);

        imagecopyresampled($dest, $im, 0, 0, $x, $y, 300, 300, $w, $h);

        imagejpeg($dest, $fullpath);
        User::updateImage($fullpath);
        return Response::json([
            'debug' => 'ok'
        ]);
    }

    public function postSnapWebcam()
    {
        $base64 = Input::get('file');

        $im = imagecreatefromstring(base64_decode($base64));
        $dest = imagecreatetruecolor(300, 300);
        imagecopyresampled($dest, $im, 0, 0, src_x, src_y, dst_w, dst_h, src_w, src_h);
    }


    public function route()
    {
        $auth = Auth::user();

        if (Auth::guest()) {
            return Redirect::route('user/login');
        } elseif (Auth::check() && $auth->tipo_id == 1) {
            return Redirect::route('admin');
        } elseif (Auth::check() && $auth->tipo_id == 2) {
            return Redirect::route('user/home');
        }
    }

    public function anyLigas()
    {
        $ligas = Liga::select(['nome', 'logo', 'info', 'id'])->paginate(15);

        return View::make(
            'user.ligas',
            compact('ligas')
        );
    }



    public function anyParticiparLiga($liga_id = null)
    {   
        $auth = Auth::user();

        $ligaUsuario = LigaUsuarioClube::whereUsuarioId($auth->id)->whereLigaId($liga_id);

        if ($ligaUsuario->count()) {

            $ligaUsuario = $ligaUsuario->first();

            if (! $ligaUsuario->ativo) {
                
                return Redirect::to("user/selecionar-jogadores-liga/{$ligaUsuario->liga_id}");

            } else {

                return Redirect::to('/');
            }
        }



        $liga = Liga::find($liga_id);

        $paises = Nacao::orderBy('nome')->lists('nome', 'id');

        if (Request::isMethod('post')) {

            $clube = null;

            try {

                if (Input::has('clube_sistema_id')) {
                    $clube = Clube::find(Input::get('clube_sistema_id'))->toArray();
                }

                $data = [
                    'liga_id'          => $liga_id,
                    'usuario_id'       => $auth->id,
                    'clube_sistema_id' => Input::get('clube_sistema_id')
                ];

                $validator = LigaUsuarioClube::validateInputs($data);


                if ($validator->passes()) {

                    LigaUsuarioClube::create($data);

                } else {

                    return Redirect::back()
                                ->withErrors($validator)
                                ->withInput()
                                ->withClube($clube);
                }

            } catch (Exception $e) {

                $errors = [
                    'message' => $e->getMessage()
                ];

                return Redirect::back()
                                ->withErrors($errors)
                                ->withInput()
                                ->withClube($clube);
            }

        }

        

        return View::make(
                'user.participar_liga',
                compact('liga', 'paises', 'clube')
        );
    }


    public function getAjaxClubes()
    {
        if (!Request::ajax()) {
            throw new \UnexpectedValueException('Requisição deve ser ajax');
        }

        $nacao_id = filter_var(Input::get('nacao_id'));
        $clubes = Clube::where('nacao_sistema_id', '=', $nacao_id)->get();

        return Response::json($clubes);
    }


    public function getAjaxListarJogadores()
    {
        if (! Request::ajax()) {
            throw new \UnexpectedValueException('Requisição deve ser ajax');
        }

        $nome = filter_var(Input::get('nome'));
        $liga_id = filter_var(Input::get('liga_id'));

        if (! LigaUsuarioClube::verificarParticipacao($liga_id)) {
            return Response::json(['error' => 'acesso não autorizado'], 403);
        }

        $jogadores = LigaJogador::jogadoresDisponiveis($liga_id)
                            ->where('nome', 'LIKE', "%$nome%")
                            ->with('posicao')
                            ->get();


        return Response::json($jogadores);
    }


    public function getSelecionarJogadoresLiga($liga_id)
    {
        if (! LigaUsuarioClube::verificarParticipacao($liga_id)) {
            return App::abort(403);            
        }

        $auth = Auth::user();

        $liga = LigaUsuarioClube::whereLigaId($liga_id)->first();

        $ligaJogadores = LigaJogador::whereUsuarioId($auth->id)
                                ->whereLigaId($liga_id)
                                ->get();

        return View::make('user.selecionar-jogadores-liga', get_defined_vars());
    }


    public function postSelecionarJogadoresLiga($liga_id)
    {

        $ligaJogador = LigaJogador::whereLigaId($liga_id);

        if ($ligaJogador->count() < 23) {
            return Redirect::back()->withFail(true);
        }


        LigaUsuarioClube::whereLigaId($liga_id)
                        ->whereUsuarioId(Auth::user()->id)
                        ->update(['ativo' => 1]);

        return Redirect::to('/home');

    }

    public function postAjaxCadastrarJogadorLiga()
    {
        $liga_id = Input::get('liga_id');
        $jogador_id = Input::get('jogador_id');

        $ligaJogador = LigaJogador::whereLigaId($liga_id);

        if ($ligaJogador->count() >= 23) {
            return Response::json([
                'error' => 'Você já possui a escalação completa para essa liga'
            ]);
        }

        if ($ligaJogador->whereJogadorId($jogador_id)->count()) {
            return Response::json([
                'error' => 'Esse jogador já foi cadastrado'
            ]);   
        }


        $dadosJogadorLiga = [
            'liga_id'    => $liga_id,
            'jogador_id' => $jogador_id,
            'usuario_id' => Auth::user()->id,
        ];

        $validator = LigaJogador::validateInputs($dadosJogadorLiga);

        if ($validator->passes()) {

            $data = LigaJogador::create($dadosJogadorLiga);

            return Response::json(['data' => $data, 'error' => false]);

        } else {

            return Response::json(['error' => $validator->messages()]);
            
        }
    }


    public function postAjaxDeletarJogadorLiga()
    {

        if (Session::token() != Input::get('_token')) {
            return Response::json(['error' => 'Acesso não autorizado'], 403);
        }

        $liga_id = Input::get('liga_id');
        $jogador_id = Input::get('jogador_id');

        $ligaJogador = LigaJogador::whereLigaId($liga_id)
                                    ->whereJogadorId($jogador_id)
                                    ->whereUsuarioId(Auth::user()->id);

        if ($ligaJogador->count()) {

            $ligaJogador->delete();

            return Response::json(['error' => false]);

        } else {

            return Response::json(['error' => 'Erro ao processar o pedido']);
        }
    }
}