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

    public function anyParticiparLiga()
    {
        return View::make('user.participar');
    }
}