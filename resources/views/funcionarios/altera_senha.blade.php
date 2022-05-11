@extends('layouts.dashboard.app')

@section('content')
<div class="content">
   <div class="container-fluid">
      <div class="row justify-content-md-center">
         <div class="col-md-7 col-lg-6">
            <div class="card">
               <center><img src="{{ asset('img/loading.gif')}}" class="card-img-top w-50 pt-3"></center>
               <div class="card-body">
                  <form action="{{ url('salvasenha') }}" method="POST" id="form-altera-senha">
                  {{ csrf_field() }}
                     <div class="form-group">
                        <div><label for="exampleInputPassword1">Senha Atual</label></div>
                        <input type="password" class="form-control" name="password_atual">
                     </div>
                     <div class="form-group">
                        <div><label for="exampleInputPassword1">Nova Senha</label></div>
                        <input type="password" class="form-control" name="password">
                     </div>
                     <div class="form-group">
                        <div><label for="exampleInputPassword1">Confirmar</label></div>
                        <input type="password" class="form-control" name="password_confirmation">
                     </div>
                  </form>
                  <button id="btn_salvar" class="botoes-acao btn btn-round btn-success" onclick="enviaForm()">
                     <span class="icone-botoes-acao mdi mdi-send"></span>
                     <span class="texto-botoes-acao"> Salvar </span>
                     <div class="ripple-container"></div>
                  </button>
                  <button  id="btn_cancelar" class="botoes-acao btn btn-round btn-default" onclick="VoltaPagina()">
                     <span class="icone-botoes-acao mdi mdi-backburger"></span>   
                     <span class="texto-botoes-acao"> Cancelar </span>
                     <div class="ripple-container"></div>
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            var tempo = 0;
            var incremento = 500;
            
            // Testar se há algum erro, e mostrar a notificação
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    setTimeout(function(){demo.notificationRight("top", "right", "rose", "{{ $error }}"); }, tempo);
                    tempo += incremento;
                @endforeach
            @endif
            demo.initFormExtendedDatetimepickers();
        });

        function enviaForm(){
            document.getElementById("form-altera-senha").submit();
        }

        function VoltaPagina() {
            window.history.back();
        }

    </script>

@endpush
