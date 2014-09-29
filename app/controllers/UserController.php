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

        if (Input::server("REQUEST_METHOD") == "POST") {
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
}