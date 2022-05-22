<p>
    Olá {{ $cadastro->razao_social }}, o seu cadastro foi analisado pelo nosso setor e foi constatada a invalidez dos dados inseridos. Por favor, envie um novo cadastro atentando-se com a inserção dos dados indeferidos.
    <ul>
        <li><b>Motivo da invalidez dos dados:</b> {{ $cadastro->justificativa }}</li>
    </ul>
</p>
<p>
    Você pode consultar o seu cadastro em nossa página de consulta, utilizando a chave de acesso do seu cadastro:
    <ul>
        <li><b>Chave de Acesso:</b> {{ $cadastro->chave }}</li>
        <li><b>Página de consulta:</b> <a href="{{url('/consultar')}}">{{url('/consultar')}}</a></li>
    </ul>
</p>