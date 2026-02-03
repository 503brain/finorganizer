<?php
require_once 'conectar_banco.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $sql_select = "SELECT * FROM receitas WHERE ID = $id";
    $result = mysqli_query($connection, $sql_select);
    
    if (mysqli_num_rows($result) > 0) {
        $receita = mysqli_fetch_assoc($result);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sql_delete = "DELETE FROM receitas WHERE ID = $id";
            
            if (mysqli_query($connection, $sql_delete)) {
                header('Location: listar_receitas.php?mensagem=Receita+excluída+com+sucesso');
                exit;
            } else {
                $erro = "Erro ao excluir: " . mysqli_error($connection);
            }
        }
    } else {
        header('Location: listar_receitas.php?mensagem=Receita+não+encontrada');
        exit;
    }
} else {
    header('Location: listar_receitas.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Receita</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .confirmacao {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }
        
        .info-receita {
            background-color: #fff;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #4CAF50;
        }
        
        .botoes {
            margin-top: 20px;
        }
        
        .btn-excluir {
            background-color: #ff6b6b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        
        .btn-excluir:hover {
            background-color: #ff5252;
        }
        
        .btn-cancelar {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-cancelar:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="div-receita">
        <h2>Excluir Receita</h2>
    </div>
    
    <div class="sidenav-receita">
        <form action="listar_receitas.php">
            <input type="image" src="https://cdn-icons-png.flaticon.com/512/1174/1174481.png" alt="Voltar">
        </form>
    </div>
    
    <div class="confirmacao">
        <h3>Confirmar Exclusão</h3>
        
        <?php if (isset($erro)): ?>
            <div style="color: red; margin: 10px 0;"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <div class="info-receita">
            <p><strong>ID:</strong> <?php echo htmlspecialchars($receita['id']); ?></p>
            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($receita['descricao_receita']); ?></p>
            <p><strong>Valor:</strong> R$ <?php echo number_format($receita['valor_receita'], 2, ',', '.'); ?></p>
        </div>
        
        <p style="color: #ff6b6b; font-weight: bold;">
            ⚠️ Tem certeza que deseja excluir esta receita? Esta ação não pode ser desfeita.
        </p>
        
        <form method="POST" class="botoes">
            <button type="submit" class="btn-excluir" onclick="return confirm('Tem certeza absoluta?')">
                Sim, Excluir Receita
            </button>
            <a href="listar_receitas.php" class="btn-cancelar">Cancelar</a>
        </form>
    </div>
</body>
</html>