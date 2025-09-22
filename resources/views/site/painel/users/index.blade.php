@extends('site.painel.templates.template')

@section('content')

<h1 class="title-pg">
	Infobase - Lista de Usuários

	<div class="btn btn-light">
		<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
	    Logout
		</a>    
		<form id="frm-logout"  action="{{ route('logout') }}" method="POST" style="display: none;">
		    {{ csrf_field() }}
		</form>
	</div>
</h1>

<a href="{{route('usuarios.create')}}" id="btn-cadastrar" type="button" class="btn btn-primary">
	<span class="glyphicon glyphicon-plus"></span> Cadastrar
</a>
@if(session()->has('message'))
    <div class="alert alert-info">
        {{ session()->get('message') }}
    </div>
@endif

<table  class="table table-hover">
	<tr>
		<th>Nome</th>
		<th>E-mail</th>
		<th>CPF</th>
		<th>Telefone</th>
		<th>Administrador</th>
		<th>Ações</th>
	</tr>
	@if(isset($users))
	@foreach($users as $user)
	<tr>
		<td>{{$user->name}}</td>
		<td>{{$user->email}}</td>
		<td>{{$user->cpf}}</td>
		<td>{{$user->telefone}}</td>
		<td>
			@if($user->admin)	
				<div class="admin">Sim</div>
			@else
				<div class="admin">Não</div>
			@endif
		<td>
			@if((Auth::user()->admin) or (Auth::user()->id == $user->id))
				<a href="{{route('usuarios.edit',$user->id)}}" class="actions edit">
				<span class="glyphicon glyphicon-pencil"></span>
				</a>
				<a href="{{route('usuarios.show',$user->id)}}" class="actions delete">
					<span class="glyphicon glyphicon-eye-open deletar"></span>
				</a>	
			@else
				<a href="{{route('usuarios.edit',$user->id)}}" class="actions edit forbidden">
				<span class="glyphicon glyphicon-pencil"></span>
				</a>
				<a href="{{route('usuarios.show',$user->id)}}" class="actions delete forbidden">
					<span class="glyphicon glyphicon-eye-open deletar"></span>
				</a>		
			@endif
			
		</td>
	</tr>
	@endforeach
	@endif
</table>

@endsection