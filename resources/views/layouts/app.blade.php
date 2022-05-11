<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema de Cadastro de Fornecedor</title>

    <!-- Scripts -->
    <script type="text/javascript" src='//code.jquery.com/jquery-1.10.2.min.js'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.css">

   <style>
/* Style The Dropdown Button */
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.caralhodown {
  position: relative;
  display: inline-block;
}

/* caralhodown Content (Hidden by Default) */
.caralhodown-content {
  display: none;
  right: 0;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the caralhodown */
.caralhodown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of caralhodown links on hover */
.caralhodown-content a:hover {background-color: #f1f1f1}

/* Show the caralhodown menu on hover */
.caralhodown:hover .caralhodown-content {
  display: block;
}

/* Change the background color of the caralhodown button when the caralhodown content is shown */
.caralhodown:hover .dropbtn {
  background-color: #3e8e41;
}
</style>
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css"> 
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/meu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/inputstyle.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    


</head>
<body>
   <div id="app">
      <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
         <div class="container-fluid">
            <img src="{{ asset('img/logo.png')}}" height="55"/>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <!-- Right Side Of Navbar -->
               <ul class="navbar-nav ml-auto">
                  <!-- Authentication Links -->
                  @guest
                     <!-- VAZIO -->
                  @else    
                     {{-- <div class="caralhodown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #000000; font-weight: bold;">
                           <i class="fa fa-cog" aria-hidden="true"></i>
                        </a>
                        <div class="caralhodown-content">
                           @if (Auth::user()->nivel == "Super-Admin")
                              <a href="{{ url('/register') }}" style="color:black;">
                                 <i class="fa fa-fw fa-user-plus"></i>Registrar Usuário
                              </a>
                           @endif
                           <a href="{{ url('/alterasenha') }}" >
                              <i class="fas fa-lock"></i> Alterar Senha
                           </a>
                           <a href="{{ url('/logout') }}" style="color:black;">
                              <i class="fa fa-fw fa-power-off"></i>Sair
                           </a>
                        </div>
                     </div> --}}
                  @endguest
               </ul>
            </div>
         </div>
      </nav>

      <main class="py-4">
         @yield('content')
      </main>
   </div>
   {{-- Vanilla Masker --}}
   <script src="{{ asset('js/vanillaMasker.min.js') }}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.js"></script>
   @stack('scripts')
</body>
</html>