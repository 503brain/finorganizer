<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Despesas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="div-despesa">
        <h2>Lista de Despesas</h2>
    </div>
    
    <div class="sidenav-receita">
        <form action="./index.html">
            <input type="image" src="https://cdn-icons-png.flaticon.com/512/1174/1174481.png" alt="Voltar">
        </form> 
        <br>
    </div>
    
    <div class="container-despesa">
        <table>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Valor (R$)</th>
                <th>Ações</th>
            </tr>
            <?php
            require_once 'conectar_banco.php';
            
            $sql = "SELECT * FROM despesas ORDER BY ID DESC";
            $result = mysqli_query($connection, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['descricao_despesa']) . "</td>";
                    echo "<td>R$ " . number_format($row['valor_despesa'], 2, ',', '.') . "</td>";
                    echo "<td>
                            <a href='editar_despesa.php?id=" . $row['id'] . "'>Editar</a> | 
                            <a href='excluir_despesa.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhuma despesa cadastrada.</td></tr>";
            }
            
            mysqli_close($connection);
            ?>
        </table>
    </div>
</body>
</html>