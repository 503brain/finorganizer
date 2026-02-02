<?php
require_once 'conectar_banco.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = mysqli_real_escape_string($connection, trim($_POST['descricao'] ?? ''));
    $valor = mysqli_real_escape_string($connection, trim($_POST['valor'] ?? ''));
    
    if (empty($descricao) || empty($valor)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Todos os campos são obrigatórios!'
        ]);
        mysqli_close($connection);
        exit;
    }
    
    if (!is_numeric($valor) || $valor <= 0) {
        echo json_encode([
            'success' => false, 
            'message' => 'Valor inválido! Insira um número positivo.'
        ]);
        mysqli_close($connection);
        exit;
    }
    
    $valor = number_format(floatval($valor), 2, '.', '');
    
    $sql = "INSERT INTO receitas (descricao_receita, valor_receita) 
            VALUES ('$descricao', '$valor')";
    
    if (mysqli_query($connection, $sql)) {
        echo json_encode([
            'success' => true, 
            'message' => 'Receita cadastrada com sucesso!',
            'id' => mysqli_insert_id($connection)
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Erro ao cadastrar receita: ' . mysqli_error($connection)
        ]);
    }
    
    mysqli_close($connection);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Método não permitido! Use POST.'
    ]);
}
?>