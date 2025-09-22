<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Painel\UserFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {   
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {   

        $users = $this->user->all();

        return view('site.painel.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        
        if(!Auth::user()->admin)
        {
            return redirect()->route('usuarios.index')
                            ->with('message', 'Você não tem permissão de acesso!');
                             
        }
        $title = 'Infobase - Cadastro de Usuários';
        
        return view('site.painel.users.create-edit',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {   
        try 
        {
            // Resgata todos os dados que vem do formulario
            $dataForm = array_merge(
                                $request->all(),
                                ['password' => bcrypt($request->input('password')

                            )]);
            
            /*
            * O tratamento abaixo, é devido ao cenário do requisito de cadastro ou edição,
            * pois quando o checkbox, referente ao usuário administrador, está 'desmarcado',
            * o request não o inseri no array que possui os dados do usuário.
            * Por isso, o tratamento abaixo, atendendo que, se o check veio desmarcado, é
            * porque o valor é falso.
            * Quando o check está marcado, o valor é carregado normalmente, neste caso, não
            * entraria no if abaixo.
            */

            if(!isset($dataForm['admin'])) 
              $dataForm['admin'] = 0; 


            
              
            // Faz o cadastro
            $insert = $this->user->create($dataForm);
            
            if ( $insert ){
                return redirect()->route('usuarios.index')
                                    ->with('message', 'Cadastrado com sucesso!');
            }
        }
        catch (\Exception $e)
        {
            
            // Tratamento de exceção para campos que estão como Unique
            $message   = $e->errorInfo[2];
            $uniq_cpf = strpos($message,'ib_users_cpf_unique');
            $uniq_email = strpos($message,'ib_users_email_unique');
            

            if ($uniq_cpf > 0)
            { 
                return redirect()->route('usuarios.create')
                                        ->with('message', 'O CPF já existe.');
            }
            else if ($uniq_email > 0)
            { 
                return redirect()->route('usuarios.create')
                                        ->with('message', 'O Email já existe.');
            }    
            else{
                return redirect()->route('usuarios.create')
                                        ->with('message', $message);
            }
        }
                       
    }

    /*
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {   
        // Recuperando usuario
        $user = $this->user->find($id);

        /*
        * Tratamento para caso o usuário force a entrada no método
        * pelo Browser. 
        */      

        if(!Auth::user()->admin && !(Auth::user()->id==$user->id))
        {   
            return redirect()->route('usuarios.index')
                            ->with('message', 'Você não tem permissão de acesso!');
        }

        $title = "Usuário: {$user->name}";

        return view('site.painel.users.show',compact('user','title'));
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   

        // Recuperando o usuario pelo id
        $user = $this->user->find($id);

        /*
        *   Tratamento para caso o usuário force a entrada no método
        *   pelo Browser 
        */      

        if(!Auth::user()->admin && !(Auth::user()->id==$user->id))
        {   
            return redirect()->route('usuarios.index')
                            ->with('message', 'Você não tem permissão de acesso!');
        }
        
        
        $title = "Editar  Usuário:  {$user->name}";
        
        return view('site.painel.users.create-edit', compact('user', 'title')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {
        try {
            //Recuperar todos dados do formulário    
            $dataForm = array_merge($request->all(),['password' => bcrypt($request->input('password'))]);

            //Recuperando o usuario para editar
            $user = $this->user->find($id);
            
            if(!isset($dataForm['admin'])) 
              $dataForm['admin'] = 0; 
            
            //Altera o usuário
            $update = $user->update($dataForm);

            // Verifica se realmente editou
            if ( $update ) {
                return redirect()
                    ->route('usuarios.index')
                    ->with('message', 'Alterado com sucesso!');
            } else {
                return redirect()
                    ->route('usuarios.edit', $id)
                    ->with('erros', 'Falha ao editar o usuário');    
            }
        } catch (\Exception $e) {
            
            // Tratamento de exceção para campos que estão como Unique
            $message   = $e->errorInfo[2];
            $uniq_cpf = strpos($message,'ib_users_cpf_unique');
            $uniq_email = strpos($message,'ib_users_email_unique');
            
            if ($uniq_cpf > 0)
            { 
                return redirect()->route('usuarios.edit',$id)
                                        ->with('message', 'O CPF já existe.');
            }
            else if ($uniq_email > 0)
            { 
                return redirect()->route('usuarios.edit',$id)
                                        ->with('message', 'O Email já existe.');
            }    
            else
                return redirect()->route('usuarios.edit',$id)
                                        ->with('message', $message);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Recuperando o usuario para ser deletado
        $user = $this->user->find($id);

        //Delete
        $delete = $user->delete();

        // Verifica se realmente deletado
        if ( $delete )
            return redirect()->route('usuarios.index')
                                ->with('message', 'Usuáro deletado!');
        else
            return redirect()->route('usuarios.show', $id)
                                ->with('erros', 'Falha ao deletar usuário');
    }

}
