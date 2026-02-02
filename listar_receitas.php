<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Receitas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="div-receita">
        <h2>Lista de Receitas</h2>
    </div>
    
    <div class="sidenav-receita">
        <form action="./index.html">
            <input type="image" src="https://cdn-icons-png.flaticon.com/512/1174/1174481.png" alt="Voltar">
        </form> 
        <br>
    </div>
    
    <div class="container-receita">
        <?php
        require_once 'conectar_banco.php';
        
        if (!$connection) {
            die("<p style='color: red;'>Erro de conexão com o banco de dados.</p>");
        }
        
        if (isset($_GET['mensagem'])) {
            echo "<div style='background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;'>
                    " . htmlspecialchars($_GET['mensagem']) . "
                  </div>";
        }
        
        $sql = "SELECT * FROM receitas ORDER BY ID DESC";
        $result = mysqli_query($connection, $sql);
        ?>
        
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Valor (R$)</th>
                <th>Ações</th>
            </tr>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['descricao_receita']) . "</td>";
                    echo "<td>R$ " . number_format($row['valor_receita'], 2, ',', '.') . "</td>";
                    echo "<td>
                            <a href='editar_receita.php?id=" . $row['id'] . "'>Editar</a> | 
                            <a href='excluir_receita.php?id=" . $row['id'] . "' 
                               onclick='return confirm(\"Tem certeza que deseja excluir esta receita?\")'>
                               Excluir
                            </a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhuma receita cadastrada.</td></tr>";
            }
            
            mysqli_close($connection);
            ?>
        </table>
    </div>
</body>
</html>