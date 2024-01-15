@extends('layouts.app')
@section('title','Editar Produto - '.$produto->titulo)
@section('content')
<h1 class="mb-3">Edição de Produto: {{$produto->titulo}}</h1>
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            {{$message}}
        </div>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>
                    {{$error}}
                </li>
                @endforeach
            </ul>
        </div>
    @endif
	<form method="POST" enctype="multipart/form-data" action="{{action('App\Http\Controllers\ProdutosController@update',$id)}}">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
		<div class="form-group mb-3">
		    <label for="sku">SKU</label>
		    <input type="text" class="form-control" id="sku" name="sku" placeholder="Digite o Código do Produto..." value="{{$produto->sku}}" required>
	 	</div>
	 	<div class="form-group mb-3">
		    <label for="titulo">Título</label>
		    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o Nome do Produto..." value="{{$produto->titulo}}" required>
	 	</div>
	 	<div class="form-group mb-3">
		    <label for="descricao">Descrição</label>
		   	<textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Digite uma breve descrição do Produto..." required>{{$produto->descricao}}</textarea>
	 	</div>
	 	<label for="preco">Preço</label>
	 	<div class="input-group mb-3">
		    <div class="input-group-prepend">
		    	<span class="input-group-text" id="basic-addon1">R$</span>
			</div>
		    <input type="number" step=".01" class="form-control" id="preco" name="preco" placeholder="0,00" value="{{$produto->preco}}" required>
	 	</div>
        <div class="input-group mb-3">
            <label for="imgproduto">Imagem</label>
            <input type="file" class="form-control-file" id="imgproduto" name="imgproduto">
        </div>
	 	<button type="submit" class="btn btn-primary" >Atualizar Produto</button>
	</form>
    <br></br>
    <a href="javascript:history.go(-1)" class="btn btn-secondary">Voltar</a>
@endsection