<p>
Olá {{ $cadastro->razao_social }}, o seu cadastro foi criado com sucesso e será analisado pelo nosso departamento.
Aguarde a resposta (que poderá se dar em até 72 horas úteis da sua solicitação), fique atento e por favor verifique a sua caixa de spam do seu e-mail periodicamente.
</p>
<p>
Você pode consultar o processo do cadastro em nossa página, utilizando a chave de acesso do cadastro:
<ul>
    <li><b>Chave de Acesso:</b> {{ $cadastro->chave }}</li>
    <li><b>Página de consulta:</b> <a href="{{url('/consultar')}}">{{url('/consultar')}}</a></li>
</ul>
</p>