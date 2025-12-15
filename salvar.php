<?php
// salvar.php

// Verifica se recebeu os dados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Pega o conteúdo enviado pelo Javascript (JSON)
    $input = file_get_contents("php://input");
    $dados = json_decode($input, true);

    $nome = $dados['nome'] ?? 'Não informado';
    $cpf = $dados['cpf'] ?? 'Não informado';
    $dataHora = date('d/m/Y H:i:s');

    // Define o nome do arquivo CSV
    $arquivo = 'cpfs_registrados.csv';

    // Verifica se o arquivo já existe para criar o cabeçalho
    $novoArquivo = !file_exists($arquivo);

    // Abre o arquivo em modo de "Append" (adicionar no final)
    $fp = fopen($arquivo, 'a');

    if ($fp) {
        // Se for arquivo novo, adiciona o cabeçalho das colunas
        if ($novoArquivo) {
            fputcsv($fp, ['Nome', 'Data e Hora']);
        }

        // Escreve os dados no CSV
        fputcsv($fp, [$nome, $dataHora]);

        // Fecha o arquivo
        fclose($fp);

        // Retorna sucesso para o navegador
        echo json_encode(['status' => 'sucesso']);
    } else {
        echo json_encode(['status' => 'erro', 'msg' => 'Não foi possível abrir o arquivo']);
    }
}
?>