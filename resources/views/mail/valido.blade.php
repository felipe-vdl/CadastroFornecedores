<p>
Olá {{ $cadastro->razao_social }}, o seu cadastro foi analisado pelo nosso setor e foi aprovado para certificação.
</p>
<p>
Você pode acessar o certificado em nossa página de consulta, utilizando a chave de acesso do seu cadastro:
<ul>
    <li><b>Chave de Acesso:</b> {{ $cadastro->chave }}</li>
    <li><b>Página de consulta:</b> <a href="{{url('/consultar')}}">{{url('/consultar')}}</a></li>
</ul>
</p>