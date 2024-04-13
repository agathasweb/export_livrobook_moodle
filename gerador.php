<?php

if (!isset($_FILES['file'])) { echo('A chave file não existe no array'); }

if (isset($_FILES['file'])) {

$arquivo = $_FILES['file'];

// Verificar se houve erro no upload
if ($arquivo['error'] === 0) {
    // Extrair informações do arquivo
    $nomeArquivo = $arquivo['name'];
    $caminhoTemporario = $arquivo['tmp_name'];
    $tamanhoArquivo = $arquivo['size'];
    $tipoArquivo = $arquivo['type'];

    $dataHoraSegundos = date('dmYHis');

    // Validar o arquivo
    if ($tamanhoArquivo <= 10485760) { // 10MB
        if ($tipoArquivo === 'application/vnd.ms-excel' || $tipoArquivo === 'text/csv') {
            // Definir o caminho final para salvar o arquivo
            $caminhoFinal = 'temp/' . $dataHoraSegundos.".csv";
            $Nomepasta = $dataHoraSegundos;
            $caminhoExporteds = 'exporteds/'.$Nomepasta.'/';

            // Mover o arquivo temporário para o caminho final
            if (move_uploaded_file($caminhoTemporario, $caminhoFinal)) {
                echo "<center>";
                echo "Parabéns! O arquivo CSV foi enviado com sucesso!";
                echo "<br><br>";
                echo "Nome do Arquivo: ".$nomeArquivo;
                echo "<br>";
                echo "Caminho do Arquivo: ".$caminhoFinal;
                echo "<br>";
                echo "Tamanho do Arquivo: ".$tamanhoArquivo;
                echo "<br>";
                echo "Tipo do Arquivo: ".$tipoArquivo;
                echo "</center>";

                // Processar o arquivo CSV (leitura e manipulação dos dados)
                // (código para leitura do CSV omitido por questão de complexidade)

                $file = $caminhoFinal;

                // Le o arquivo CSV e armazena os dados em um array
                $dados = array();
                $file = fopen($file, "r");

                // Ignora a primeira linha (cabeçalho)
                $linha = fgetcsv($file);

                while (($linha = fgetcsv($file)) !== false) {

                    $dados[] = $linha;
                }

                fclose($file);

                foreach ($dados as $linha) {
                    $titulo = $linha[1]; // Extrair o título da segunda coluna
                    $conteudo = $linha[4]; // Extrair o conteúdo da quinta coluna

                    $tituloCorrigido = substr($titulo, 0, -4);

                    // Criar o nome do arquivo HTML
                    $nomeArquivoHtml = $tituloCorrigido.".html";
                    // Gerar o conteúdo HTML
                    $html = "<html><body><p align='center'>$conteudo</p></body></html>";

                    // Verifica se a pasta já existe
                    if (!is_dir($caminhoExporteds)) {
                        // Cria a pasta com permissão 0777
                        mkdir($caminhoExporteds, 0777, true);
                    }

                    // Salvar arquivos HTML com os conteúdos
                    file_put_contents($caminhoExporteds.$nomeArquivoHtml, $html);

                    echo($titulo);
                    echo('<br>');
                    //echo($conteudo);
                    echo('<br><br>');

                }

                /*

                // Gerar arquivos HTML para cada linha do CSV
                foreach ($dados as $linha) {
                $titulo = $linha[0]; // Extrair o título da primeira coluna
                $conteudo = $linha[1]; // Extrair o conteúdo da segunda coluna

                // Criar o nome do arquivo HTML
                $nomeArquivoHtml = strtolower(str_replace(" ", "_", $titulo)) . ".html";

                // Gerar o conteúdo HTML
                $html = "<html><head><title>$titulo</title></head><body>$conteudo</body></html>";

                // Salvar o conteúdo HTML em um arquivo
                file_put_contents($nomeArquivoHtml, $html);
                }
                */



            } else {
                echo "Erro ao mover o arquivo!";
            }
        } else {
            echo "Erro: tipo de arquivo inválido!";
        }
    } else {
        echo "Erro: arquivo muito grande!";
    }
} else {
    switch ($arquivo['error']) {
        case UPLOAD_ERR_INI_SIZE:
            echo "Erro: O arquivo excede o tamanho máximo permitido pelo servidor.";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            echo "Erro: O arquivo excede o tamanho máximo permitido pelo formulário.";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "Erro: Nenhum arquivo foi enviado.";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo "Erro: Diretório temporário não encontrado.";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo "Erro: Falha ao escrever o arquivo no disco.";
            break;
        case UPLOAD_ERR_EXTENSION:
            echo "Erro: Uma extensão PHP impediu o upload do arquivo.";
            break;
        default:
            echo "Erro no upload do arquivo: " . $arquivo['error'];
    }
}
}

?>
