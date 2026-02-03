<?php
require_once 'conectar_banco.php';

$mensagem = '';
$erro = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $sql_select = "SELECT * FROM receitas WHERE ID = $id";
    $result = mysqli_query($connection, $sql_select);
    
    if (mysqli_num_rows($result) > 0) {
        $receita = mysqli_fetch_assoc($result);
        $descricao = $receita['descricao_receita'];
        $valor = $receita['valor_receita'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nova_descricao = mysqli_real_escape_string($connection, trim($_POST['descricao'] ?? ''));
            $novo_valor = mysqli_real_escape_string($connection, trim($_POST['valor'] ?? ''));
            
            if (empty($nova_descricao) || empty($novo_valor)) {
                $erro = 'Todos os campos são obrigatórios!';
            } elseif (!is_numeric($novo_valor) || $novo_valor <= 0) {
                $erro = 'Valor inválido! Insira um número positivo.';
            } else {
                $novo_valor = number_format(floatval($novo_valor), 2, '.', '');
                
                $sql_update = "UPDATE receitas 
                              SET descricao_receita = '$nova_descricao', 
                                  valor_receita = '$novo_valor' 
                              WHERE ID = $id";
                
                if (mysqli_query($connection, $sql_update)) {
                    $mensagem = 'Receita atualizada com sucesso!';
                    $descricao = $nova_descricao;
                    $valor = $novo_valor;
                } else {
                    $erro = 'Erro ao atualizar: ' . mysqli_error($connection);
                }
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
    <title>Editar Receita</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validarFormulario() {
            const descricao = document.getElementById('descricao').value.trim();
            const valor = document.getElementById('valor').value.trim();
            
            if (!descricao || !valor) {
                alert('Por favor, preencha todos os campos!');
                return false;
            }
            
            if (isNaN(valor) || parseFloat(valor) <= 0) {
                alert('Por favor, insira um valor numérico válido!');
                return false;
            }
            
            return true;
        }
    </script>
    <style>
        .container-editar {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .botoes {
            margin-top: 30px;
            text-align: center;
        }
        
        .btn-salvar {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        
        .btn-salvar:hover {
            background-color: #218838;
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
        
        .mensagem {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .mensagem.sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .mensagem.erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="div-receita">
        <h2>Editar Receita</h2>
    </div>
    
    <div class="sidenav-receita">
        <form action="listar_receitas.php">
            <input type="image" src="https://cdn-icons-png.flaticon.com/512/1174/1174481.png" alt="Voltar">
        </form>
    </div>
    
    <div class="container-editar">
        <?php if ($mensagem): ?>
            <div class="mensagem sucesso"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        
        <?php if ($erro): ?>
            <div class="mensagem erro"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="id">ID da Receita:</label>
                <input type="text" id="id" value="<?php echo htmlspecialchars($id); ?>" disabled>
                <small style="color: #666;">ID não pode ser alterado</small>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição da Receita:</label>
                <input type="text" id="descricao" name="descricao" 
                       value="<?php echo htmlspecialchars($descricao); ?>" 
                       required placeholder="Digite a descrição">
            </div>
            
            <div class="form-group">
                <label for="valor">Valor da Receita (R$):</label>
                <input type="number" id="valor" name="valor" 
                       value="<?php echo htmlspecialchars($valor); ?>" 
                       step="0.01" min="0" required placeholder="0.00">
            </div>
            
            <div class="botoes">
                <button type="submit" class="btn-salvar">Salvar Alterações</button>
                <a href="listar_receitas.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>