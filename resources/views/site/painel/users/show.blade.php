@extends('site.painel.templates.template')

@section('content')

<h1 class="title-pg">
	<a href="{{route('usuarios.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
	Usuário: <b>{{$user->name}}<b>
</h1>

@if ( isset($errors) && count($errors) > 0 )
	<div class="alert alert-danger">
		@foreach ($errors->all() as $error)
			<p>{{$error}}</p>
		@endforeach
	</div>	
@endif

<p><b>Nome:</b> {{$user->name}} </p>
<p><b>E-mail:</b> {{$user->email}} </p>
<p><b>CPF:</b> {{$user->cpf}} </p>
<p><b>Telefone:</b> {{$user->telefone}} </p>
<p><b>Administrador: </b>
	@if($user->admin)	
		Sim
	@else
		Não
	@endif
</p>

<hr>
@if((Auth::user()->admin))
{!! Form::open(['route' => ['usuarios.destroy', $user->id]]) !!}
{!! method_field('DELETE') !!}
	{!! Form::submit("Deletar Usuario: $user->name", ['id' => 'btn-deletar' , 'class' => 'btn btn-danger']) !!}
{!! Form::close() !!}	
@else
	Somente usuário com o perfil "Administrador" pode deletar usuários.
@endif
<script>
$("#btn-deletar").click(function(){
    if(confirm("Deseja excluiro usuário?")){
        $("#btn-deletar").attr();
    }
    else{
        return false;
    }
});
</script>

@endsection