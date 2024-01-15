@extends('layouts.app')
@section('title','Lista de Produtos')
@section('content')
    <h1>Produtos</h1>
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            {{$message}}
        </div>
    @endif
    <div class="row">
        <div class="com-md-12">
                <form method="POST" action="{{url('produtos/busca')}}">
                @csrf
                <div class="input-group mb-3">
                    <input  type="text" class="form-control" id="busca" name="busca" placeholder="Procurar por produto..." value="{{$campo_busca}}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="com-md-12">
                <form method="POST" action="{{url('produtos/ordem')}}">
                @csrf
                <div class="input-group mb-3">
                    <select name="ordem" id="ordem" class="form-control">
                        <option value="1" @if($ordem == 1) selected @endif>Título (A-Z)</option>
                        <option value="2" @if($ordem == 2) selected @endif>Título (Z-A)</option>
                        <option value="3" @if($ordem == 3) selected @endif>Preço crescente</option>
                        <option value="4" @if($ordem == 4) selected @endif>Preço decrescente</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary">
                            Ordenar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @foreach ($produtos as $produto)
        <div class="col-md-3">
            @if(file_exists("./img/produtos/".md5($produto->id).".jpg"))
                <img src="{{url('img/produtos/'.md5($produto->id).'.jpg')}}" alt="Imagem Produto" class="img-fluid img-thumbnail">
            @endif
            <h4 class="text-center">
                <a href="{{URL::to('produtos')}}/{{$produto->id}}">{{$produto->titulo}}</a>
            </h4>
            <h4 class="text-center"><strong>Preço: </strong>R$ {{number_format($produto->preco,2,',','.')}}</h4>
            <div class="text-center">
                @if($produto->preco == $produto_mais_caro )  
                <h4 class="alert alert-danger">Maior preço</h4>
                @endif
                @if($produto->preco == $produto_mais_barato )  
                <h4 class="alert alert-success">Menor preço</h4>
                @endif
            </div>
            @if(Auth::check())
            <div class="mb-3" style="margin-top: 3px;">
                <form method="POST" action="{{action('App\Http\Controllers\ProdutosController@destroy',$produto->id)}}">
                @csrf
                    <input type="hidden" name="_method" value="DELETE">
                <a class="btn btn-warning" href="{{URL::to('produtos')}}/{{$produto->id}}/edit">Editar</a>
                    <button class="btn btn-danger">Excluir</button>
                </form>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    <br></br>
    <div>
        <p>
            O valor médio dos produtos é:<strong> R$ {{number_format($media_valor,2,',','.')}}</strong>
        </p>
        <p>
            O valor total dos produtos é:<strong> R$ {{number_format($soma_total,2,',','.')}}</strong>
        </p>
        <p>
            Número de produtos é:<strong> {{$contagem_produtos}}</strong>
        </p>
        <p>
            Número de produtos maior que R$ 10,00 é:<strong> {{$maior_dez}}</strong>
        </p>
    </div>
    <br></br>
    {{$produtos->links()}}
@endsection