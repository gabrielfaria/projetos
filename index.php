<?php

$token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjI0ODQ2ODUxOCwidWlkIjoyMTU1NTY1OCwiaWFkIjoiMjAyMy0wNC0wMlQxOTozMzoxOC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6NzI3Njc5OCwicmduIjoidXNlMSJ9.0vLCvz1GvoCFSa_F3o1gLPEvB5-cyvu1j4ucNACOCdU';
$apiUrl = 'https://api.monday.com/v2';
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

$query = '{users {
					id
					name
				}
			}';

$data = @file_get_contents($apiUrl, false, stream_context_create([
	'http' => [
		'method' => 'POST',
		'header' => $headers,
		'content' => json_encode(['query' => $query]),
	]
]));

if (empty($data)) {
	echo 'Não houve nenhum retorno da API, tente novamente mais tarde ou altere sua busca';
	exit;
}

$nomeWapper = '';
$responseContent = json_decode($data, true);

$data = $responseContent['data']['users'];

foreach ($data as $key => $value) {
	$nomeWapper .= '<li><input type="radio" id="'.$value['id'].'" name="wappers" value="'.$value['name'].'"><label class="nome-wapper" for="'.$value['id'].'">'.$value['name'].'</label></li>';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulário de exemplo</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			text-align: center;
		}
		
		h1 {
			margin-top: 50px;
		}
		
		form {
			display: inline-block;
			text-align: left;
			margin-top: 30px;
		}
		
		label {
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
			font-size: 18px;
			text-align: left;
		}
		
		input[type=text], select {
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			width: 100%;
			box-sizing: border-box;
			font-size: 16px;
		}
		
		input[type=submit] {
			background-color: #FF7A59;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
			margin-top: 20px;
		}
		
		input[type=submit]:hover {
			background-color: #FF7A59;
		}
		
        span {
            margin-bottom: 20px;
            display: block;
            font-size: 12px;
            color: #ff0000;
        }
        
        .extra-fields {
            display: none;
        }
        
        .extra-fields label, .extra-fields input {
            display: block;
            margin-top: 10px;
        }
        
        #show-fields:checked ~ .extra-fields {
            display: block;
        }


		.container-busca{
			width: 80%;
			height: 60%;
			background-color: #F8F8F8;
			margin: 0 auto;
			padding: 20px;
			display: flex;
			align-items: center;
    		justify-content: initial;
		}
		.container-busca input[type=text]{
			width: 30%;
			display: flex;
		}
		.container-list{
			width: 80%;
			height: 60%;
			background-color: #F8F8F8;
			margin: 0 auto;
		}
		.nome-wapper{
			color: #000000;
			display: contents;
			font-size: 13px;
			font-weight: 100;
		}
		ul {
			display: flex;
			flex-wrap: wrap;
			list-style: none;
			text-align: left;
		}
		li {
			width: 20%;
    		margin-bottom: 10px;
		}

	</style>
</head>
<body>

	<h1>Gerador de Assinaturas</h1>
	<img width="337" height="73" src="https://www.wapstore.com.br/wp-content/themes/wap1/img/logo.svg" alt="Logo" style="width: 100%;">

	<div class="container-list">
		<label for="nomeBusca">Procurar por nome:</label>
		<input type="text" id="nomeBusca" name="nome" autocomplete="off">
		<ul id="lista">
			<?php
				echo $nomeWapper;
			?>
		</ul>
	</div>

	<form action="gerador.php" method="POST">
		<label for="nome">Nome:</label>
		<input type="text" id="nome" name="nome" autocomplete="off">
		<span>Para gerar assinatura de todos os wappers, mantenha este campo nome vazio</span>
		
		<label for="template">Template:</label>
		<select id="template" name="template" required>
			<option value="">Selecione um template</option>
			<option value="wapstore">Wapstore</option>
			<option value="wellcommerce">Wellcommerce</option>
			<option value="wap_well">Wap_Well</option>
		</select>
		
		<div style="display: flex; align-items: baseline; margin-top: 20px;">
			<input type="checkbox" id="show-fields" name="adicionar" onclick="toggleFields()">
			<label for="show-fields" style="margin-right: 20px;">Adicionar telefone e LinkedIn:</label>
		</div>
		
		<div id="fields" style="display: none;">
		<span>A geração de todas as assinaturas anula as informações de telefone e linkedin</span>
			<label for="telefone">Telefone:</label>
			<input type="text" id="telefone" name="telefone" autocomplete="off">
			<label for="linkedin">LinkedIn:</label>
			<input type="text" id="linkedin" name="linkedin" autocomplete="off">
		</div>
		
		<input type="submit" value="Enviar">
	</form>

	<script>
	const listaNaoOrdenada = document.getElementById('lista');
	const campoDeTexto = document.getElementById('nomeBusca');
	const radios = document.querySelectorAll('input[type="radio"]');
	const inputTexto = document.getElementById('nome');

	radios.forEach(radio => {
	radio.addEventListener('click', () => {
		inputTexto.value = radio.value;
	});
	});


// Armazena uma cópia da lista original
const listaCompleta = Array.from(listaNaoOrdenada.children);

function filtrarLista(filtro) {
  // Filtra a lista completa em vez da lista original
  const itensFiltrados = listaCompleta.filter(item => item.textContent.includes(filtro));
  // Remove todos os itens da lista
  listaNaoOrdenada.innerHTML = '';
  // Adiciona os itens filtrados de volta à lista
  itensFiltrados.forEach(item => listaNaoOrdenada.appendChild(item));
}

campoDeTexto.addEventListener('input', () => {
  const filtro = campoDeTexto.value.trim();
  filtrarLista(filtro);
});

    function toggleFields() {
        var showFields = document.getElementById("show-fields");
        var fields = document.getElementById("fields");
        
		document.getElementById("telefone").value = '';
		document.getElementById("linkedin").value = '';

        if (showFields.checked) {
            fields.style.display = "block";
        } else {
            fields.style.display = "none";
        }
    }
</script>

</body>
</html>