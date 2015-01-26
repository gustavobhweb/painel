<?php

class AdminController extends BaseController
{

    protected $messages = [
        'required' => 'O campo é obrigatório',
        'max'      => 'O máximo permitido é :max',
        'exists'   => 'O valor selecionado não existe em nossa base de dados'
    ];


    public function indexAction()
    {   

        if (Request::isMethod('post')) {

            $rules = [
                'nome'       => 'required|unique:ligas',
                'dataInicio' => 'required|regex: /\d{2}\/\d{2}\/\d{4}/',
                'dataFim'    => 'required|regex: /\d{2}\/\d{2}\/\d{4}/',
                'info'       => 'required'
            ];

            $messages = [
                'required' => 'Esse campo é obrigatório',
                'regex'    => 'Formato inválido',
                'unique'   => 'Esse :attribute já se encontra em uso'
            ];

            $inputs = Input::only('nome', 'dataInicio', 'dataFim', 'info');
            $validation = Validator::make($inputs, $rules, $messages);

            if ($validation->passes()) {

                try {
                    $inputs['dataInicio'] = DateTime::createFromFormat('d/m/Y', $inputs['dataInicio'])
                                                    ->format('Y-m-d');

                    $inputs['dataFim'] = DateTime::createFromFormat('d/m/Y', $inputs['dataFim'])
                                                  ->format('Y-m-d');    
                    Liga::create($inputs);

                    return Redirect::back()->with(['message' => 'Liga cadastrada com successo!']);

                } catch (\InvalidArgumentException $e) {
                    return Redirect::back()
                                    ->withErrors($validation + ['message' => $e->getMessage()]);
                }   

            } else {
                return Redirect::back()->withErrors($validation);
            }
        }


        $ligas = Liga::paginate(10);

        return View::make('admin.index', compact('ligas'));
    }

    public function anyEditarLiga($id = null) 
    {
        $liga = Liga::find($id);

        if (Request::isMethod('post')) {

            $rules = [
                'nome'       => 'required',
                'dataInicio' => 'required|regex: /\d{2}\/\d{2}\/\d{4}/',
                'dataFim'    => 'required|regex: /\d{2}\/\d{2}\/\d{4}/',
                'info'       => 'required',
                'logo'       => 'required|mimes:jpg,png,gif,jpeg'
            ];

            $messages = [
                'required' => 'Esse campo é obrigatório',
                'regex'    => 'Formato inválido',
                'unique'   => 'Esse :attribute já se encontra em uso'
            ];

            $inputs = Input::only('nome', 'dataInicio', 'dataFim', 'info');
            $validation = Validator::make(Input::all(), $rules, $messages);


           if ($validation->passes()) {

               try {

                   $dir = public_path('ligas/');

                   $extension = Input::file('logo')->getClientOriginalExtension();

                   $filename = md5(uniqid()) . ".$extension";

                   Input::file('logo')->move($dir, $filename);


                   $inputs['logo'] = $filename;

                   $inputs['dataInicio'] = DateTime::createFromFormat('d/m/Y', $inputs['dataInicio'])
                                                   ->format('Y-m-d');

                   $inputs['dataFim'] = DateTime::createFromFormat('d/m/Y', $inputs['dataFim'])
                                                 ->format('Y-m-d');    
                   $liga->fill($inputs)->save();

                   return Redirect::back()->with([
                        'message' => 'Liga atualizada com sucesso!'
                    ]);

               } catch (\InvalidArgumentException $e) {
                    return Redirect::back()
                                   ->withErrors($validation + ['message' => $e->getMessage()]);
               }   

           } else {
               return Redirect::back()->withErrors($validation);
           }
        }

        return View::make('admin.editar_liga', compact('liga'));
    }


    public function anyCadastrarClube()
    {   

        if (Request::isMethod('post')) {
            $rules = [
                'nome'              => 'required',
                'abreviatura'       => 'required|max:3',
                'nacao_id'  => 'required|exists:nacoes_sistema,id'
            ];

                
            $inputs = Input::only('nome', 'abreviatura', 'nacao_id');

            $validation = Validator::make($inputs, $rules, $this->messages);

            try {
                if ($validation->passes()) {

                    Clube::create($inputs);

                    return Redirect::back()->with(['message' => 'Clube criado com sucesso']);

                } else {

                    return Redirect::back()->withInput()->withErrors($validation);
                }

            } catch (\Exception $e) {
                return Redirect::back()->withInput()->with(['message' => $e->getMessage()]);
            }
        }

        $nacoes = Nacao::lists('nome', 'id');

        return View::make('admin.cadastrar_clube', compact('nacoes'));
    }

    public function anyCadastrarJogador()
    {

        if (Request::isMethod('post')) {

            $rules = [
                'apelido'         => 'required|min:3',
                'clube_id'        => 'required|exists:clubes,id',
                'data_nascimento' => 'required|regex:/\d{2}\/\d{2}\/\d{4}/',
                'nacao_id'        => 'required|exists:nacoes,id',
                'posicao_id'      => 'required|exists:posicoes,id',
                'nome'            => 'required',
                'foto'            => 'required'
            ]; 

            $inputs = Input::except('_token');

            $validation = Validator::make($inputs, $rules, $this->messages);

            if ($validation->passes()) {

                if (Input::hasFile('foto')) {

                    $ext = Input::file('foto')->getClientOriginalExtension();

                    $filename = uniqid() . ".$ext";

                    $dir = public_path("jogadores/");

                    Input::file('foto')->move($dir, $filename);

                    $inputs['foto'] = $filename;
                }

                Jogador::create($inputs);

            } else {
                return Redirect::back()->withErrors($validation)->withInput();
            }
        }


        $clubes  = Clube::lists('nome', 'id');
        $nacoes  = Nacao::lists('nome', 'id');
        $posicoes = Posicao::lists('nome', 'id');

        return View::make(
            'admin.cadastrar_jogador',
            compact('clubes', 'nacoes', 'posicoes')
        );
    }

}