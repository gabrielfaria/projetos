<?php
$nome_wapper = $_POST['nome'];
$template = $_POST['template'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['template'])) {

    $token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjI0ODQ2ODUxOCwidWlkIjoyMTU1NTY1OCwiaWFkIjoiMjAyMy0wNC0wMlQxOTozMzoxOC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6NzI3Njc5OCwicmduIjoidXNlMSJ9.0vLCvz1GvoCFSa_F3o1gLPEvB5-cyvu1j4ucNACOCdU';
    $apiUrl = 'https://api.monday.com/v2';
    $headers = ['Content-Type: application/json', 'Authorization: ' . $token];

    $busca = '';
    if (!empty($nome_wapper)) {
        $busca = '(name: "' . $nome_wapper . '")';
    }

    $query = '  {
             users ' . $busca . '{
                id
                title
                name
                email
                photo_small
                url
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

    $contagem = 0;
    $htmlFiles = array();
    $prefix = '';
    $responseContent = json_decode($data, true);

    // Cria um novo objeto ZipArchive
    $zip = new ZipArchive();

    // Caminho completo para o arquivo ZIP que você deseja criar
    $zipFilename = 'temp/assinaturas-' . $template . '.zip';

    // Cria um arquivo ZIP e abra-o para gravação
    if ($zip->open($zipFilename, ZipArchive::CREATE) === TRUE) {

        $data = $responseContent['data']['users'];

        if (empty($data)) {
            echo 'Não encontramos registros, repita a busca "tente usar o nome idêntico ao cadastro no monday"';
            exit;
        }

        foreach ($data as $key => $value) {
            if ($value['title'] != '' || $value['title'] != NULL) {
                switch ($template) {
                    case 'wapstore':
                        $prefix = 'wapstore';
                        require('wapstore.php');
                        break;
                    case 'wellcommerce':
                        $prefix = 'wellcommerce';
                        require('wellcommerce.php');
                        break;
                    case 'wap_well':
                        $prefix = 'wap-well';
                        require('wap_well.php');
                        break;

                    default:
                        require('wapstore.php');
                        break;
                }

                $fileName_a = 'temp/' . $prefix . '-' . $value['name'] . '.html';
                file_put_contents($fileName_a, $htmlContent);

                // Adiciona arquivo ao zip
                $file = 'temp/' . $prefix . '-' . $value['name'] . '.html';
                $zip->addFile($file, $prefix . '-' . $value['name'] . '.html');

                $htmlFiles[] = $fileName_a;
            }
        }
    }

    $zip->close();


    // Itera sobre a lista de arquivos e exclui cada um
    foreach ($htmlFiles as $file_a) {
        if (file_exists($file_a)) {
            unlink($file_a);
        }
    }

    // Envie o arquivo ZIP para download
    header("Content-type: application/zip");
    header("Content-Disposition: attachment; filename=$zipFilename");
    header("Content-length: " . filesize($zipFilename));
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile("$zipFilename");

    // Exclua o arquivo ZIP da pasta de destino (opcional)
    unlink($zipFilename);
}
