<?php
header('Content-Type: application/json');

try {
    require_once 'conectar_banco.php';
    
    $sql_receitas = "SELECT SUM(valor_receita) as total FROM receitas";
    $result_receitas = mysqli_query($connection, $sql_receitas);
    $total_receitas = 0;
    if ($row = mysqli_fetch_assoc($result_receitas)) {
        $total_receitas = $row['total'] ? (float)$row['total'] : 0;
    }
    
    $sql_despesas = "SELECT SUM(valor_despesa) as total FROM despesas";
    $result_despesas = mysqli_query($connection, $sql_despesas);
    $total_despesas = 0;
    if ($row = mysqli_fetch_assoc($result_despesas)) {
        $total_despesas = $row['total'] ? (float)$row['total'] : 0;
    }
    
    $saldo_final = $total_receitas - $total_despesas;
    
    echo json_encode([
        'success' => true,
        'total_receitas' => $total_receitas,
        'total_despesas' => $total_despesas,
        'saldo' => $saldo_final,
        'saldo_final' => $saldo_final  
    ]);
    
    mysqli_close($connection);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>