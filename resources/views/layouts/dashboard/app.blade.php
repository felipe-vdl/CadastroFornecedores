<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!-- Favicons -->
  <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
  <title>
    Cadastro de Fornecedores
  </title>
  <!-- Bootstrap 5.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/material-dashboard.css?v=2.0.1') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <!-- Documentation extras -->
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{ asset('assets/assets-for-demo/demo.css') }}" rel="stylesheet"/>
  <style>
      .card {
          background-color: #FDFDFD;
      }
  </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar" data-color="rose" data-background-color="black" data-image="{{ asset('img/prefeitura.png') }}">
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
                <div class="user">
                    <div class="user-info ">
                        <a data-toggle="collapse" class="username text-center">
                            <span>
                                {{ substr(Auth::user()->name, 0, strpos(Auth::user()->name, ' ')) }}
                            </span>
                        </a>
                    </div>
                </div>
                <ul class="nav">
                <li class="nav-item ">
                    <a class="nav-link" href="/cadastros">
                    <i class="material-icons">summarize</i>
                    <p> Cadastros </p>
                    </a>
                </li>
                @if (Auth::user()->nivel == "Super-Admin")
                <li class="nav-item">
                    <a class="nav-link" href="/usuarios">
                    <i class="material-icons">person</i>
                    <p> Usuários </p>
                    </a>
                </li>
                @endif
                </ul>
            </div>
        </div>
        <!-- End Sidebar -->
        <div id="mainpanel" class="main-panel" style="transition: none;">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
                <div class="container-fluid">
                    <div>
                        <a id="sidebartoggler" href="#" style="color:inherit;">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="navbar-wrapper">
                        <span class="navbar-brand">Cadastro de Fornecedores</span>
                    </div>
                    @if(session()->get('sucesso_alteracao_senha'))
                        <div class="alert alert-success m-0">
                            {{ session()->get('sucesso_alteracao_senha') }}
                        </div>
                    @endif
                    @if(session()->get('sucesso_edicao_usuario'))
                        <div class="alert alert-success m-0">
                            {{ session()->get('sucesso_edicao_usuario') }}
                        </div>
                    @endif
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
            @yield('content')
            <!-- Footer -->
            <footer>
                <div class="container">
                    <div class="row justify-content-center px-3">
                        © 2022 Equipe de Desenvolvimento de Sistemas - Subsecretaria da Tecnologia da Informação - Prefeitura Municipal de Mesquita - RJ 
                    </div>
                </div>
            </footer>
            <!-- End Footer -->
            <!-- Loading Modal -->
            <div class="modal fade" id="modaleventclick" tabindex="-1" role="dialog" aria-labelledby="modaleventclickLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaleventclickLabel">Enviando, por favor aguarde.</h5>
                    </div>
                     
                    <div class="modal-body">
                        <center>
                            <div class="loader"></div>
                        </center>
                    </div>
                  </div>
                </div>
            </div>
            <!-- End Loading Modal -->
        </div>
    </div>
</body>
<!-- SCRIPTS -->
{{-- Sidebar Collapse --}}
<script>
    const sidebar = document.querySelector('#sidebar');
    const mainPanel = document.querySelector('#mainpanel');
    const toggler = document.querySelector('#sidebartoggler');

    toggler.addEventListener('click', () => {
        mainPanel.classList.toggle('w-100');
        sidebar.classList.toggle('collapse');
    });
</script>
<!-- Bootstrap 5.1 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-material-design.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!--  Google Maps Plugin  -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
<!--	Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{ asset('assets/js/plugins/nouislider.min.js') }}"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{ asset('assets/js/plugins/bootstrap-selectpicker.js') }}"></script>
<!--	Plugin for Tags, full documentation here: http://xoxco.com/projects/code/tagsinput/  -->
<script src="{{ asset('assets/js/plugins/bootstrap-tagsinput.js') }}"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{ asset('assets/js/plugins/jasny-bootstrap.min.js') }}"></script>
<!-- Plugins for presentation and navigation  -->
<script src="{{ asset('assets/assets-for-demo/js/modernizr.js') }}"></script>
<!-- Material Dashboard Core initialisations of plugins and Bootstrap Material Design Library -->
<script src="{{ asset('assets/js/material-dashboard.js?v=2.0.1') }}"></script>
<!-- Dashboard scripts -->
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="{{ asset('assets/js/plugins/arrive.min.js" type="text/javascript') }}"></script>
<!-- Forms Validations Plugin -->
<script src="{{ asset('assets/js/plugins/jquery.validate.min.js') }}"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="{{ asset('assets/js/plugins/chartist.min.js') }}"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{ asset('assets/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{{ asset('assets/js/plugins/jquery-jvectormap.js') }}"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="{{ asset('assets/js/plugins/nouislider.min.js') }}"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{ asset('assets/js/plugins/jquery.select-bootstrap.js') }}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('assets/js/plugins/jquery.datatables.js') }}"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="{{ asset('assets/js/plugins/sweetalert2.js') }}"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{ asset('assets/js/plugins/jasny-bootstrap.min.js') }}"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
<!-- demo init -->
<script src="{{ asset('assets/js/plugins/demo.js') }}"></script>
<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin  -->
<script src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datetime-moment.js') }}"></script>
@stack('scripts')

</html>