{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing DOMPDF</title>
    <style>
        body {

        }

        #logotipo {
            padding: 0;
            margin: 0;
            max-width: 300px;
        }

        #heading {
            height: 20%;
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <table>
        <thead>

        </thead>
        <tbody>

        </tbody>
    </table>
    <p>Teste DOMPDF</p>
    <ul>
        <li>{{ $cadastro->razao_social }}</li>
    </ul>
</body>
</html> --}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<title>Relatório</title>
<style type="text/css">
@page {
	margin: 2cm;
	margin-top: 160px;
	margin-bottom: 0px;
}
body {
    font-family: 'Times New Roman', Times, serif;
    font-size:15px;
	 margin: 2.5cm 0;
	 text-align: justify;
}
#header { 
	position: fixed; 
	top: -30px; 
	left: 0px; 
	right: 0px;  
	height: 50px; }
#footer {
	position: fixed;
	left: 0;
	right: 0;
	color: #000000;
	font-size: 0.9em;
}
#footer {
  bottom: -20px;
}
#header table {
}
#footer table {
	width: 100%;
	border-collapse: collapse;
	border: none;
}
#header td {
}
#footer td {
  padding: 0;
	width: 10%;
}
.page-footer {
  text-align: center;
}
hr {
  page-break-after: always;
  border: 0;
}
table.separate {
  border-collapse: separate;
  border-spacing: 20pt;
  
}
td{
    padding: 4px;
}
.container{
	 justify-content: flex-start;
}
.semsopimagem {
  margin-top: 1cm;
  height: 260px !important;
  width: 260px !important;
}
.Imangemsemsop{
  margin: 0 auto !important;
}
.page-number {
  text-align: center;
}
.page-number:before {
  content: "Pagina " counter(page);
}
#watermark { 
    font-family: 'Times New Roman', Times, serif;
    font-size: 250px;
    position: fixed;
    left: 10%;
    top: -8%;
    transform: rotate(-45deg);
    opacity: .15;
}
</style>
</head>

	<body>
		
		<div id="watermark">C.P.L.</div>

		<div id="header">
		  <table style="width: 100%; margin-top: 0.5%; border: 1px solid black;">
		    <tr>
                <td style="width: 33%;">
		    	    <center><img src="{{ asset('img/logo.png') }}" height="250%" width="90%"/></center>
                </td>
                <td style="border-left: 1px solid black;">
                    <p style="margin: none; font-size: 30px; text-align: center;">ESTADO DO RIO DE JANEIRO</p>
                    <p style="margin: none; font-size: 30px; text-align: center;">PREFEITURA MUNICIPAL DE MESQUITA</p>
                    <p style="margin: none; font-size: 30px; text-align: center;">Secretaria Municipal de Governança</p>
                    <p style="margin: none; font-size: 30px; text-align: center; font-weight: bold;">Comissão Especial de Licitação</p>
                </td>
		    </tr>
		  </table>
		</div>
        <br>
		{{-- <div id="footer">
		    <table>
                <tr>
                    <div class="page-number"></div>
                    <td style="font-size: 15px;">Consolidado pela Lei n.° 8.883/94</td>
                    <td style="font-size: 15px; text-align: right;">Fundamento Legal: Lei n.° 8.666/93</td>
                </tr>
		    </table>
		</div> --}}
        <br>
        <br>
		<table style="width: 100%; padding: 1%; border: 1px solid black;">
			<tr>
				<td style="width: 10%;"><center>Número: <p style="margin: none; margin-bottom: 1rem;">{{ $cadastro->chave }}</p></center></td>
				<td style="width: 30%;"><center>Ramo: <p style="margin: none; margin-bottom: 1rem;">{{ $cadastro->produtos }}</p></center></td>
				<td style="width: 10%;"><center>Ano: <p style="margin: none; margin-bottom: 1rem;">{{date('Y', strtotime($cadastro->data_certificado))}}</p></center></td>
                <td style="width: 20%;"><center>CNPJ/CPF: <p style="margin: none; margin-bottom: 1rem;">{{ $cadastro->cnpj }}</p></center></td>
                <td style="width: 15%;"><center>Inscrição Municipal: <p style="margin: none; margin-bottom: 1rem;">{{ $cadastro->inscricao_municipal }}</p></center></td>
                <td style="width: 15%;"><center>Inscrição Estadual: <p style="margin: none; margin-bottom: 1rem;">{{ $cadastro->inscricao_estadual }}</p></center></td>
			</tr>
		</table>
        <br>
        <table style="width: 100%; padding: 1%; border: 1px solid black;">
            <tr>
                <td>Empresa: {{$cadastro->razao_social}}</td>
            </tr>
            <tr style="width: 100%">
                <td style="width: 33%;">Logradouro: {{$cadastro->rua.', nº '.$cadastro->numero_rua}}</td>
                <td style="width: 33%;">Bairro: {{$cadastro->bairro}}</td>
                <td style="width: 33%;">Município: {{$cadastro->municipio}}</td>
            </tr>
            <tr style="width: 100%">
                <td style="width: 25%;">CEP: {{$cadastro->cep}}</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 33%;">Telefone: {{ $cadastro->telefone }}</td>
                <td style="width: 33%;">E-mail: {{ $cadastro->email }}</td>
                <td style="width 33%;"></td>
            </tr>
        </table>
        <br>
        <table style="width: 100%; padding: 1%; border: 1px solid black;">
            <tr>
                <td style="width: 16%;"><center>Emissão: <p style="margin: none;">{{ date('d/m/Y', strtotime($cadastro->data_certificado)) }}</p></center></td>
                <td style="width: 16%;"><center>Validade: <p style="margin: none;">{{ date('d/m/Y', strtotime($cadastro->validade_certificado)) }}</p></center></td>
                <td style="width: 68%;"><center>AVISO <p style="margin: none;">O recadastramento deverá ser providenciado com 30 (trinta) dias de antecedência.</center></td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; font-size: 15px;">Consolidado pela Lei n.° 8.883/94</td>
                <td style="width: 50%; font-size: 15px; text-align: right">Fundamento Legal: Lei n.° 8.666/93</td>
            </tr>
        </table>
		{{-- <table style="width: 100%">
			<tr>
				<td><b>Tipo de Documento: </b></td>
				<td  style="padding-left: 45%"><b>Data:</b></td>
			</tr>
		</table>
	
		<br>

		<table>
			<tr>
				<td><p style="text-align: justify;"></p></td>
			</tr>
		</table>

		<br>

		<h1 style="text-align:center;">  
				<span style="text-transform:uppercase">indeferido</span>
		</h1>

		<div style="text-align:center;">
			<div>RECEBIDO POR</div>
			<div class="col-md-12 text-center"></div>
		</div>

		<br>

		<table>
			<tr>
				<td><p><b>Justificativa:</b></p></td>
			</tr>
		</table> --}}
	</body>
</html>