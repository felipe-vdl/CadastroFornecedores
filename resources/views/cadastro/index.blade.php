@extends('layouts.dashboard.app')
@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
            @if(session()->get('success'))
              <div class="alert alert-success m-0">
                  {{ session()->get('success') }}
              </div>
			      @endif
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                      <i class="material-icons"></i>
                  </div>
                  <h4 class="card-title">Empresas Cadastradas</h4>
                </div>
                <div class="card-body ">
                  <div class="material-datatables">
                      <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <th>Razão Social</th>
                            <th>Chave</th>
                            <th>CNPJ</th>
                            <th>Produtos/Serviços</th>
                            <th>Porte da Empresa</th>
                            <th>Status</th>
                            <th class="text-right">Ações</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th><input class="filter-input form-control" data-column="0" type="text" placeholder="Filtrar Razão Social"></input></th>
                            <th><input class="filter-input form-control" data-column="1" type="text" placeholder="Filtrar Chave"></input></th>
                            <th><input class="filter-input form-control" data-column="2" type="text" placeholder="Filtrar CNPJ"></input></th>
                            <th><input class="filter-input form-control" data-column="3" type="text" placeholder="Filtrar Produtos/Serviços"></input></th>
                            <th><input class="filter-input form-control" data-column="4" type="text" placeholder="Filtrar Porte da Empresa"></input></th>
                            <th><input class="filter-input form-control" data-column="5" type="text" placeholder="Filtrar Status"></input></th>
                            <th class="text-right">Ações</th>
                          </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($cadastros as $cadastro)
                              <tr>
                                  <td>{{$cadastro->razao_social}}</td>
                                  <td>{{$cadastro->chave}}</td>
                                  <td>{{$cadastro->cnpj}}</td>
                                  <td>{{$cadastro->produtos}}</td>
                                  <td>{{$cadastro->porte_empresa}}</td>
                                  <td>
                                    @switch($cadastro->status)
                                      @case(0)
                                        <a style="color: gray">Em Análise</a>
                                        @break
                                      @case(1)
                                        <a style="color: green">Aprovado</a>
                                        @break
                                      @case(2)
                                        <a style="color: blue">Aguardando Documentos</a>
                                        @break
                                      @case(3)
                                        <a style="color: red">Recusado</a>
                                        @break
                                    @endswitch
                                  </td>
                                  <td class="text-right">
                                    <a  href="{{ url("/cadastros/$cadastro->id") }}" 
                                        class="btn btn-info btn-sm"
                                        title="Detalhar cadastro.">
                                        <i class='material-icons'>search</i>
                                    </a>
                                    <a  href="{{ url("/cadastros/$cadastro->id/edit") }}" 
                                        class="btn btn-warning btn-sm"
                                        title="Avaliar cadastro.">
                                        <i class='material-icons'>edit</i>
                                    </a>
                                  </td>
                              </tr>    
                            @endforeach
                        </tbody>
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
{{-- DataTables --}}
<script type="text/javascript">
// Tabela
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
        {"targets": 6, "orderable": false},
        { className: "text-center", "targets": [0, 1, 2, 3, 4, 5] },
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