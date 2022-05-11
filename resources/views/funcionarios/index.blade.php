@extends('layouts.dashboard.app')
@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                      <i class="material-icons"></i>
                  </div>
                  <div class="d-flex justify-content-between">
                    <h4 class="card-title">Usuários</h4>
                    <a href="{{ url('/register') }}" class="btn btn-round btn-success">
                      <i class="fa fa-fw fa-user-plus"></i> Novo Usuário
                    </a>
                  </div>
                </div>
                <div class="card-body ">
                  <div class="material-datatables">
                      <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Nível</th>
                            <th class="disabled-sorting text-right">Ações</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($funcionarios as $funcionario)
                              <tr>
                                <td>{{$funcionario->id}}</td>
                                <td>{{$funcionario->name}}</td>
                                <td>{{$funcionario->email}}</td>
                                <td>{{$funcionario->nivel}}</td>
                                <td>
                                  <a
                                    href="{{url("usuarios/$funcionario->id/edit")}}"
                                    class="btn btn-warning btn-sm" 
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Editar usuário.">
                                    <i class="material-icons">edit</i>
                                  </a>
                                </td>
                              </tr>    
                          @endforeach
                      </tbody>
                        <tfoot>
                          <tr>
                            <th>Razão Social</th>
                            <th>CNPJ</th>
                            <th>Produtos e Serviços</th>
                            <th>Porte Da Empresa</th>
                            <th class="text-right">Ações</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
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
      $('#datatables').DataTable({
         language : {
            'url' : '{{ asset('js/portugues.json') }}',
            "decimal": ",",
            "thousands": "."
         },
         stateSave: true,
    	   stateDuration: -1,
			responsive: true,
			deferRender: true,
			compact: true,
			processing: true,
			/* columns: [
				{ data : 'id',   name : 'id' },
				{ data : 'name',        	name : 'name' },
				{ data : 'email',       name : 'email' },
				{ data : 'nivel',  name : 'nivel' },
				{ data : 'acoes',        	name : 'acoes' },
			], */
			"columnDefs": [
    			{ "width": "15%", "targets": 4 },
    			{ className: "text-center", "targets": [4] },
  			]
     });
   });
 </script>
@endpush