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
                  <h4 class="card-title">Empresas Cadastradas</h4>
                </div>
                <div class="card-body ">
                  <div class="material-datatables">
                      <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <th>Razão Social</th>
                            <th>CNPJ</th>
                            <th>Produtos e Serviços</th>
                            <th>Porte Da Empresa</th>
                            <th class="disabled-sorting text-right">Ações</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Razão Social</th>
                            <th>CNPJ</th>
                            <th>Produtos e Serviços</th>
                            <th>Porte Da Empresa</th>
                            <th class="text-right">Ações</th>
                          </tr>
                        </tfoot>
                        {{-- <tbody>
                            @foreach ($dados as $dado)
                              <tr>
                                  <td>{{$dado->razao_social}}</td>   
                                  <td>{{$dado->cnpj}}</td>   
                                  <td>{{$dado->produtos}}</td>   
                                  <td>{{$dado->porte_empresa}}</td>   
                                  <td></td>   
                              </tr>    
                            @endforeach
                        </tbody> --}}
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

    //init wizard

    demo.initMaterialWizard();

    // Javascript method's body can be found in assets/js/demos.js
    demo.initDashboardPageCharts();

    demo.initCharts();

  });
</script>
<script type="text/javascript">
  $(document).ready(function() {

    demo.initVectorMap();
  });
</script>
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
    serverSide: true,
    ajax: "{{ url('/home/datatables') }}",
    columns: [
      { data : 'razao_social',   name : 'razao_social' },
      { data : 'cnpj',        	name : 'cnpj' },
      { data : 'produtos',       name : 'produtos' },
      { data : 'porte_empresa',  name : 'porte_empresa' },
      { data : 'acoes',        	name : 'acoes' },
    ],
    "columnDefs": [
        { "width": "15%", "targets": 4 },
        { className: "text-center", "targets": [4] },
      ]
    });
  });
</script>
@endpush