<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançamento de despesas</title>
    <link rel="stylesheet" href="style.css">
    <script src="script_despesa.js" defer></script>
</head>
<body>
    <div class="div-despesa">
        <h2>Lançamento de despesas</h2>
    </div>
    
    <div class="sidenav-receita">
        <form action="./index.html">
            <input type="image" src="https://cdn-icons-png.flaticon.com/512/1174/1174481.png" alt="Voltar">
        </form> 
        <br>
        <form action="./listar_despesas.php">
            <input type="image" src="https://www.bimu.it/wp-content/uploads/2018/04/Icon_forms-1.png" alt="Listar receitas">
        </form>
    </div>
    
    <div class="container-despesa">
        <form id="formDespesa" method="POST" action="./processar_despesa.php">
            <table>
                <tr>
                    <th>Descrição da despesa</th>
                    <th>Valor da despesa (R$)</th>
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
                        <button type="submit" id="btnLancar">Lançar Despesa</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>