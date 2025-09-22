@extends('site.painel.templates.template')

@section('content')


<h1 class="title-pg">
	<div class='usuario'>
		<a href="{{route('usuarios.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>

		{{ isset($title) ? $title : 'Infobase Prova Php' }}
	</div>	
</h1>

@if(session()->has('message'))
    <div class="alert alert-info">
        {{ session()->get('message') }}
    </div>
@endif

@if ( isset($errors) && count($errors) > 0 )
	<div class="alert alert-danger">
		@foreach ($errors->all() as $error)
			<p>{{$error}}</p>
		@endforeach
	</div>	
@endif

@if (isset($user))
	<form class="form form-edit-create" method="post" action="{{route('usuarios.update',$user->id)}}">
	{!! method_field('PUT') !!}
@else	
	<form class="form" method="post" action="{{route('usuarios.store')}}">
@endif

	{!! csrf_field() !!} 
	<div class="form-group">
		<label >Nome</label>
		<input type="text" name="name" placeholder="Nome: " class="form-control" value="{{ isset($user) ? $user->name : old('name') }}" >
	</div>

	 <div class="form-group">
	 	<label >Email</label>
		<input type="text" name="email" placeholder="E-mail: " class="form-control" value="{{isset($user) ? $user->email : old('email')}}">
	</div>
	
	<div class="form-group">
		<label >CPF</label>
		<input id="cpf" type="text" name="cpf" placeholder="CPF: " class="form-control" value="{{isset($user) ? $user->cpf : old('cpf')}}">
	</div>

	<div class="form-group">
		<label >Telefone</label>
		<input id="telefone" type="text" name="telefone" placeholder="Telefone: " class="form-control" value="{{isset($user) ? $user->telefone : old('telefone')}}">
	</div>

	<div class="form-group">
		<label >Senha</label>
		<input type="password" name="password" placeholder="Nova Senha: " class="form-control" value="">
	</div> 

	<div class="form-group">
		<!-- 
			O if abaixo, é para inserir uma classe que desabilite o check-box para 
			caso o usuário não ser administrador, o mesmo não poder o tornar como um.
	 	-->
		<input type="checkbox" id="admin" name="admin" value="{{isset($user) ? $user->admin : 1}}" 
		@if(!(Auth::user()->admin))
			onclick="return false"
			class="check-opacity"
		@endif
		"> 
		<label >Administrador</label>
	</div>
	
	<button id="enviar" class="btn btn-primary">Enviar</button>
</form>

<script type="text/javascript">
$( document ).ready(function() {
	
	/*
		Por algum motivo, quando o model recupera os dados do usuário, 
		o checkbox não é alimentado  (marcado/desmarcado) corretamente.
		Devido a falta de tempo hábil para corrigir este problema de 
		conversão, foram inseridas as soluções com o nome de "Solução - 1",
		que é a para tratar o checkbox no carregamento da página e
		"Solução - 2", que é para recuperar o valor correto do check e enviar 
		para o Controller (método UserController@update).
	*/

	// "Solução - 1"
	@if(isset($user))
	if( {{$user->admin}} == 1 ) {
		$("#admin").attr( 'checked', true );
	}
	else{
		$("#admin").attr( 'checked', false );
	}	
	@endif

	// Mascaras dos campos telefone e cpf
	$("#telefone").mask('(99)9999-9999');

	$("#cpf").mask('999.999.999-99');
});


$( "#enviar" ).click(function() {

	// "Solução - 2"
	if( $("#admin").is(":checked") ) {
		$("#admin").val('1') ;
	}
	else{
		$("#admin").val('0') ;	
	}	


	/*
		Por algum motivo, a função $().unmask, não funcionou.
		Devido a falta de tempo hábil para trabalhar nesta solução,
		Foi utilizada a função "Replace".
	*/

	// $("#telefone").val().replace(/[\(\)\.\s-]+/g,'')
	var str_tel = $("#telefone").val();
	str_tel = str_tel.replace(/[\(\)\.\s-]+/g,'');
	$("#telefone").val(str_tel);

	// $("#cpf").val().replace(/[\(\)\.\s-]+/g,'')
	var str_cpf = $("#cpf").val();
	str_cpf = str_cpf.replace(/[\.\s-]+/g,'');
	$("#cpf").val(str_cpf);	

	

});
</script>

@endsection