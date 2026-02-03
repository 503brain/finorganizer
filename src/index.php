<?php
session_start();

require_once 'conectar_banco.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (empty($_POST['user']) || empty($_POST['pass'])) {
        $erro = 'Por favor, preencha todos os campos';
    } else {
        $usuario = trim($_POST['user']);
        $senha = $_POST['pass'];
        
        $query = "SELECT id, usuario, senha FROM login WHERE usuario = ?";
        $stmt = mysqli_prepare($connection, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $usuario);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($resultado) === 1) {
                $dados_usuario = mysqli_fetch_assoc($resultado);
                
                if ($senha === $dados_usuario['senha']) {
                    $_SESSION['usuario_id'] = $dados_usuario['id'];
                    $_SESSION['usuario_nome'] = $dados_usuario['usuario'];
                    $_SESSION['logado'] = true;
                    
                    header('Location: index.html');
                    exit();
                } else {
                    $erro = 'Senha incorreta';
                }
            } else {
                $erro = 'Usuário não encontrado';
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $erro = 'Erro no processamento do login';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FinOrganizer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>FinOrganizer</h1>
            <p>Faça login para acessar o sistema</p>
        </div>
        
        <?php if (!empty($erro)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="login-form">
            <div class="form-group">
                <label for="user">Usuário</label>
                <input type="text" id="user" name="user" required 
                       placeholder="Digite seu usuário"
                       value="<?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="pass">Senha</label>
                <input type="password" id="pass" name="pass" required 
                       placeholder="Digite sua senha">
            </div>
            
            <button type="submit" class="submit-btn">
                Entrar
            </button>
        </form>
        
        <div class="login-footer">
            <p>Sistema de Gestão Financeira</p>
        </div>
    </div>
</body>
</html>