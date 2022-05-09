@extends('layouts.app')

@section('content')
    
<div class="container" style="padding-top:5rem">
   <div class="row justify-content-md-center">
      <div class="col-md-auto">
         <div class="card" style="width: 18rem;">
            <center><img src="{{ asset('img/loading.gif')}}" class="card-img-top" style="width:66% "></center>
            <div class="card-body">
               <form action="{{ url('salvasenha') }}" method="POST" class="    form-horizontal" id="form-altera-senha">
               {{ csrf_field() }}
                   
                   <div class="form-group">
                     <label for="exampleInputPassword1">Senha Atual</label>
                     <input type="password" class="form-control" name="password_atual" placeholder="Senha">
                  </div>

                  <div class="form-group">
                     <label for="exampleInputPassword1">Nova Senha</label>
                     <input type="password" class="form-control" name="password" placeholder="Senha">
                  </div>

                  <div class="form-group">
                     <label for="exampleInputPassword1">Confirmar</label>
                     <input type="password" class="form-control" name="password_confirmation" placeholder="Senha">
                  </div>
               </form>

               <button id="btn_salvar" class="botoes-acao btn btn-round btn-success" onclick="enviaForm()">
                  <span class="icone-botoes-acao mdi mdi-send"></span>
                  <span class="texto-botoes-acao"> Salvar </span>
                  <div class="ripple-container"></div>
               </button>

               <button  id="btn_cancelar" class="botoes-acao btn btn-round btn-primary" onclick="VoltaPagina()">
                  <span class="icone-botoes-acao mdi mdi-backburger"></span>   
                  <span class="texto-botoes-acao"> Cancelar </span>
                  <div class="ripple-container"></div>
               </button>

            </div>      
         </div>   
      </div>
   </div>
</div>

@include('layouts.footer')
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
