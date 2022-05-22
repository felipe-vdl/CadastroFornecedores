<p>
Olá {{ $cadastro->razao_social }}, o seu cadastro foi analisado pelo nosso setor e está aguardando o reenvio de documentos que foram sinalizados como indeferidos/pendentes.
Para dar seguimento ao processo, por favor, acesse a página de consulta utilizando a chave do seu cadastro e efetue o reenvio dos documentos solicitados.
</p>
<p>
Você pode efetuar o envio dos documentos em nossa página de consulta, utilizando a chave de acesso do seu cadastro:
<ul>
    <li><b>Chave de Acesso:</b> {{ $cadastro->chave }}</li>
    <li><b>Página de consulta:</b> <a href="{{url('/consultar')}}">{{url('/consultar')}}</a></li>
</ul>
</p>
<p>
Os documentos serão analisados pelo nosso setor após o envio, que retornará a resposta em até 72 horas úteis do envio.
</p>