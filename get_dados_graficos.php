<?php
session_start();
header('Content-Type: application/json');

try {
    require_once 'conectar_banco.php';
    
    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
        exit;
    }
    
    $usuario_id = $_SESSION['usuario_id'];
    
    $sql_receitas = "SELECT SUM(valor_receita) as total FROM receitas WHERE id_usuario = ?";
    $stmt_receitas = mysqli_prepare($connection, $sql_receitas);
    mysqli_stmt_bind_param($stmt_receitas, "i", $usuario_id);
    mysqli_stmt_execute($stmt_receitas);
    $result_receitas = mysqli_stmt_get_result($stmt_receitas);
    
    $total_receitas = 0;
    if ($row = mysqli_fetch_assoc($result_receitas)) {
        $total_receitas = $row['total'] ? (float)$row['total'] : 0;
    }
    
    $sql_despesas = "SELECT SUM(valor_despesa) as total FROM despesas WHERE id_usuario = ?";
    $stmt_despesas = mysqli_prepare($connection, $sql_despesas);
    mysqli_stmt_bind_param($stmt_despesas, "i", $usuario_id);
    mysqli_stmt_execute($stmt_despesas);
    $result_despesas = mysqli_stmt_get_result($stmt_despesas);
    
    $total_despesas = 0;
    if ($row = mysqli_fetch_assoc($result_despesas)) {
        $total_despesas = $row['total'] ? (float)$row['total'] : 0;
    }
    
    $saldo = $total_receitas - $total_despesas;
    
    $sql_ultimas_receitas = "SELECT descricao_receita, valor_receita FROM receitas WHERE id_usuario = ? ORDER BY id DESC LIMIT 5";
    $stmt_ultimas_receitas = mysqli_prepare($connection, $sql_ultimas_receitas);
    mysqli_stmt_bind_param($stmt_ultimas_receitas, "i", $usuario_id);
    mysqli_stmt_execute($stmt_ultimas_receitas);
    $result_ultimas_receitas = mysqli_stmt_get_result($stmt_ultimas_receitas);
    
    $ultimas_receitas = [];
    while ($row = mysqli_fetch_assoc($result_ultimas_receitas)) {
        $ultimas_receitas[] = $row;
    }
    
    $sql_ultimas_despesas = "SELECT descricao_despesa, valor_despesa FROM despesas WHERE id_usuario = ? ORDER BY id DESC LIMIT 5";
    $stmt_ultimas_despesas = mysqli_prepare($connection, $sql_ultimas_despesas);
    mysqli_stmt_bind_param($stmt_ultimas_despesas, "i", $usuario_id);
    mysqli_stmt_execute($stmt_ultimas_despesas);
    $result_ultimas_despesas = mysqli_stmt_get_result($stmt_ultimas_despesas);
    
    $ultimas_despesas = [];
    while ($row = mysqli_fetch_assoc($result_ultimas_despesas)) {
        $ultimas_despesas[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'total_receitas' => $total_receitas,
        'total_despesas' => $total_despesas,
        'saldo' => $saldo,
        'ultimas_receitas' => $ultimas_receitas,
        'ultimas_despesas' => $ultimas_despesas
    ]);
    
    mysqli_close($connection);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>