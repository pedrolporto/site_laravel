<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    public function index(){
        $data['titulo'] = "Contato";

        return view('contato',$data);
    }

    public function enviar(Request $request){

        $dados_email = array(
            'nome'=>$request->input('nome'),
            'email'=>$request->input('email'),
            'assunto'=>$request->input('assunto'),
            'descricao'=>$request->input('descricao')
        );

        Mail::send('email.contato', $dados_email, function($message){
            $message->from('formulario@pontocom.net','Formulário de Contato');
            $message->subject('Mensagem enviada pelo formmulário de contato');
            $message->to('contato@pontocom.net');
        });

        return redirect('contato')->with('success','Mensagem enviada com sucesso!');

    }
}
