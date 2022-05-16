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
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Nível</th>
                            <th class="disabled-sorting text-right">Ações</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($funcionarios as $funcionario)
                              <tr>
                                <td>{{$funcionario->name}}</td>
                                <td>{{$funcionario->email}}</td>
                                <td>{{$funcionario->nivel}}</td>
                                <td class="text-right">
                                  <a
                                    href="{{url("usuarios/$funcionario->id/edit")}}"
                                    class="btn btn-warning btn-sm p-2"
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
                            <th><input class="filter-input form-control" data-column="0" type="text" placeholder="Filtrar Nome"></input></th>
                            <th><input class="filter-input form-control" data-column="1" type="text" placeholder="Filtrar E-mail"></input></th>
                            <th><input class="filter-input form-control" data-column="2" type="text" placeholder="Filtrar Nível"></input></th>
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
     // Configuração geral
    const table = $('#datatables').DataTable({
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
      "columnDefs": [
        {"targets": 3, "orderable": false}
      ]
    });

     //Filtro
    $('.filter-input').keyup(function() {
      table.column( $(this).data('column') )
      .search( $(this).val() )
      .draw();
    });
   });
 </script>
@endpush