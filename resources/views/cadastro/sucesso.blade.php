@extends('layouts.app')

@section('content')
   <div class="container">
         <div class="card">
               <div class="card-header">
                 Cadastro Realizado com Sucesso
               </div>
               <div class="card-body">
                 <h5 class="card-title">Os dados da sua empresa agora constam na base de dados da prefeitura </h5>
                 {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
                 <center>
                    <a href="/" class="btn btn-primary">Voltar para o Formulario</a>
                 </center>
               </div>
             </div>
   </div>
	<div class="container" style="padding-top: 30px">
		@include('layouts.footer')
	</div>
@endsection

