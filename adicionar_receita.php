<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançamento de receitas</title>
    <link rel="stylesheet" href="style.css">
    <script src="script_receita.js" defer></script>
</head>
<body>
    <div class="div-receita">
        <h2>Lançamento de receitas</h2>
    </div>
    
    <div class="sidenav-receita">
        <form action="./index.html">
            <input type="image" src="https://cdn-icons-png.flaticon.com/512/1174/1174481.png" alt="Voltar">
        </form> 
        <br>
        <form action="./listar_receitas.php">
            <input type="image" src="https://cdn-icons-png.flaticon.com/512/11637/11637719.png" alt="Listar receitas">
        </form>
    </div>
    
    <div class="container-receita">
        <form id="formReceita" method="POST" action="processar_receita.php">
            <table>
                <tr>
                    <th>Descrição da receita</th>
                    <th>Valor da receita (R$)</th>
                    <th>Ação</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="descricao" name="descricao" placeholder="Digite a descrição" required>
                    </td>
                    <td>
                        <input type="number" id="valor" name="valor" placeholder="0.00" step="0.01" min="0" required>
                    </td>
                    <td>
                        <button type="submit" id="btnLancar">Lançar Receita</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>