<p>Olá {{ $cadastro->razao_social }}, o seu cadastro foi criado com sucesso e será analisado pelo nosso departamento.</p>
<p>Aguarde a resposta (poderá se dar em até 48 horas úteis da sua solicitação), fique atento e por favor verifique a sua caixa de spam periodicamente.</p>

<p>Você pode consultar o processo do cadastro em nossa página, utilizando a chave de acesso do cadastro.</p>

<p><b>Chave de Acesso:</b> {{ $cadastro->chave }}</p>
<p><b>Página de consulta:</b></p> <a href="{{url('/consultar')}}">{{url('/consultar')}}</a>