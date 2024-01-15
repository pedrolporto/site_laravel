<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutosController extends Controller
{
    public function index(){

        // $produtos = Produtos::all();
        $produtos = Produtos::paginate(4)->withQueryString();

        $produto_mais_caro = Produtos::all()->max('preco');

        $produto_mais_barato = Produtos::all()->min('preco');

        $produto_valor_medio = Produtos::all()->avg('preco');

        $soma_total = Produtos::all()->sum('preco');

        $contagem_produtos = Produtos::all()->count();

        $maior_dez = Produtos::where('preco','>',10)->count();

        // echo '<pre>';
        // print_r($produtos);
        // echo '</pre>';

            return view('produtos.index',array('produtos'=>$produtos,'campo_busca'=>null, 'ordem'=>null
                        , 'produto_mais_caro'=>$produto_mais_caro, 'produto_mais_barato'=>$produto_mais_barato
                        , 'media_valor' =>$produto_valor_medio, 'soma_total'=>$soma_total, 'contagem_produtos'=>$contagem_produtos
                        , 'maior_dez'=>$maior_dez));
    }

    public function show($id){
        $produto = Produtos::with('mostrarComentarios')->find($id);

        return view('produtos.show',array('produto'=>$produto));

    }

    public function create(){

        if(Auth::check()){
            return view('produtos.create');
        }else{
            return redirect('login');
        }
        

    }

    public function store(Request $request){

        $this->validate($request,[
            'sku'=> 'required|unique:produtos|min:3'
            ,'titulo'=> 'required|min:3'
            ,'descricao'=> 'required|min:10'
            ,'preco'=> 'required|numeric'
        ]);

        $produto = new Produtos();
        $produto->sku = $request->input('sku');
        $produto->titulo = $request->input('titulo');
        $produto->descricao = $request->input('descricao');
        $produto->preco = $request->input('preco');

        if($produto->save()){
            return redirect('produtos/create')->with('success','Produto cadastrado com sucesso!');
        }

    }

    public function edit($id){
        
        $produto = Produtos::find($id);

        return view('produtos.edit',compact('produto','id'));

    }

    public function update(Request $request,$id){

        $produto = Produtos::find($id);

        $this->validate($request,[
            'sku'=> 'required|min:3'
            ,'titulo'=> 'required|min:3'
            ,'descricao'=> 'required|min:10'
            ,'preco'=> 'required|numeric'
        ]);

        if($request->hasFile('imgproduto')){
            $imagem = $request->file('imgproduto');
            $nome_arquivo = md5($id).".".$imagem->getClientOriginalExtension();
            // printf($nome_arquivo);die;
            $request->file('imgproduto')->move(public_path('./img/produtos/'),$nome_arquivo);
        }

        $produto->sku = $request->get('sku');
        $produto->titulo = $request->get('titulo');
        $produto->descricao = $request->get('descricao');
        $produto->preco = $request->get('preco');

        if($produto->save()){
            return redirect('produtos/'.$id.'/edit')->with('success','Produto atualizado com sucesso!');
        }

    }

    public function destroy($id){
        $produto = Produtos::find($id);
        
        if(file_exists("./img/produtos/".md5($id).".jpg")){
            unlink("./img/produtos/".md5($id).".jpg");
        }

        $produto->delete();
        return redirect()->back()->with('success','Produto Removido com Sucesso!');
    }

    public function busca(Request $request){

        $campo_busca = $request->input('busca');

        $stancia_produtos = Produtos::where('titulo', 'LIKE', '%'.$campo_busca.'%')
        ->orwhere('descricao', 'LIKE', '%'.$campo_busca.'%');

        $produto_mais_caro = $stancia_produtos->max('preco');

        $produto_mais_barato = $stancia_produtos->min('preco');

        $produto_valor_medio = $stancia_produtos->avg('preco');

        $soma_total = $stancia_produtos->sum('preco');

        $contagem_produtos = $stancia_produtos->count();

        $maior_dez = $stancia_produtos->where('preco','>',10)->count();

        $produtos = Produtos::where('titulo', 'LIKE', '%'.$campo_busca.'%')
                        ->orwhere('descricao', 'LIKE', '%'.$campo_busca.'%')
                        ->paginate(4)->withQueryString();


        return view('produtos.index',array('produtos'=>$produtos,'campo_busca'=>$campo_busca, 'ordem'=>null
        , 'produto_mais_caro'=>$produto_mais_caro, 'produto_mais_barato'=>$produto_mais_barato
        , 'media_valor' =>$produto_valor_medio, 'soma_total'=>$soma_total, 'contagem_produtos'=>$contagem_produtos
        , 'maior_dez'=>$maior_dez));
    }

    public function ordem(Request $request){
        $ordem_input = $request->input('ordem');

        if($ordem_input==1){
            $campo = 'titulo';
            $tipo = 'asc';
        }else if($ordem_input==2){
            $campo = 'titulo';
            $tipo = 'desc';
        }else if($ordem_input==2){
            $campo = 'preco';
            $tipo = 'asc';
        }else {
            $campo = 'preco';
            $tipo = 'desc';
        }

        $produtos = Produtos::orderBy($campo,$tipo)->paginate(4)->withQueryString();

        $produto_mais_caro = Produtos::all()->max('preco');

        $produto_mais_barato = Produtos::all()->min('preco');

        $produto_valor_medio = Produtos::all()->avg('preco');

        $soma_total = Produtos::all()->sum('preco');

        $contagem_produtos = Produtos::all()->count();

        $maior_dez = Produtos::where('preco','>',10)->count();


        return view('produtos.index',array('produtos'=>$produtos,'campo_busca'=>null, 'ordem'=>$ordem_input
        , 'produto_mais_caro'=>$produto_mais_caro, 'produto_mais_barato'=>$produto_mais_barato
        , 'media_valor' =>$produto_valor_medio, 'soma_total'=>$soma_total, 'contagem_produtos'=>$contagem_produtos
        , 'maior_dez'=>$maior_dez));
    }
}