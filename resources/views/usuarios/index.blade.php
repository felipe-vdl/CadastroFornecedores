<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!-- Favicons -->
  <link rel="apple-touch-icon" href="../assets/img/apple-icon.png">
  <link rel="icon" href="../assets/img/favicon.png">
  <title>
    Cadastro de Fornecedores
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <link rel="stylesheet" href="../assets/css/material-dashboard.css?v=2.0.1">
  <!-- Documentation extras -->
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/assets-for-demo/demo.css" rel="stylesheet" />
  <!-- iframe removal -->
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="{{ asset('img/prefeitura.png') }}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo" style="padding-left: 38px;">
        <a class="simple-text logo-normal">
            <img src="{{ asset('img/logo.png')}}" height="55"/>
        </a>
      </div>
      <div class="sidebar-wrapper" >
        <div class="user" style="padding-left: 38px;" >
          <div class="user-info ">
            <a data-toggle="collapse" class="username" >
              <span>
                {{$usuario->name}}
              </span>
            </a>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" href="/home">
              <i class="material-icons">dashboard</i>
              <p> Empresas </p>
            </a>
          </li>
          @if (Auth::user()->nivel == "Super-Admin")
          <li class="nav-item active">
            <a class="nav-link" href="/usuarios">
              <i class="material-icons">person</i>
              <p> Usuários </p>
            </a>
          </li>
          @endif
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="/home">Cadastro de Fornecedores</a>
          </div>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions
                      <b class="caret"></b>
                    </span>

                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  @if (Auth::user()->nivel == "Super-Admin")
                  <a href="{{ url('/register') }}" style="color:black;">
                    <i class="fa fa-fw fa-user-plus"></i>Registrar Usuário
                 </a>
                 @endif
                  <a href="{{ url('/alterasenha') }}" style="color:black;">
                     <i class="material-icons">lock</i>Alterar a Senha<br>  
                  </a>
                  <a href="{{ url('/logout') }}" style="color:black;">
                     <i class="material-icons">exit_to_app</i>Sair
                  </a>
                </div>
              </li>
            </ul>
          </div>
          
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-12">
                 <div class="card ">
                     <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                           <i class="material-icons"></i>
                        </div>
                        <h4 class="card-title">Usuários</h4>
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
                                      <td></td>
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
      <footer class="footer ">
      
      </footer>
   </div>
</div>
</body>
<!--   Core JS Files   -->
<script src="../assets/js/core/jquery.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/bootstrap-material-design.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Google Maps Plugin  -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin  -->
<script src="../assets/js/plugins/moment.min.js"></script>
<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
<script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<!--	Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="../assets/js/plugins/nouislider.min.js"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
<!--	Plugin for Tags, full documentation here: http://xoxco.com/projects/code/tagsinput/  -->
<script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
<!-- Plugins for presentation and navigation  -->
<script src="../assets/assets-for-demo/js/modernizr.js"></script>
<!-- Material Dashboard Core initialisations of plugins and Bootstrap Material Design Library -->
<script src="../assets/js/material-dashboard.js?v=2.0.1"></script>
<!-- Dashboard scripts -->
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="../assets/js/plugins/arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="../assets/js/plugins/jquery.validate.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="../assets/js/plugins/chartist.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="../assets/js/plugins/jquery-jvectormap.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="../assets/js/plugins/nouislider.min.js"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="../assets/js/plugins/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="../assets/js/plugins/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="../assets/js/plugins/sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="../assets/js/plugins/fullcalendar.min.js"></script>
<!-- demo init -->
<script src="../assets/js/plugins/demo.js"></script>
<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

</html>
