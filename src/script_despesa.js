document.addEventListener('DOMContentLoaded', function() {
    const formDespesa = document.getElementById('formDespesa');
    const btnLancar = document.getElementById('btnLancar');
    
    if (formDespesa) {
        formDespesa.addEventListener('submit', function(event) {
            event.preventDefault();
            enviarDespesa();
        });
    }
    
    if (btnLancar) {
        btnLancar.addEventListener('click', function(event) {
            event.preventDefault();
            enviarDespesa();
        });
    }
});

function enviarDespesa() {
    const descricao = document.getElementById('descricao').value.trim();
    const valor = document.getElementById('valor').value.trim();
    
    if (!descricao || !valor) {
        alert('Por favor, preencha todos os campos!');
        return;
    }
    
    if (isNaN(valor) || parseFloat(valor) <= 0) {
        alert('Por favor, insira um valor numérico válido!');
        return;
    }
    
    const btnLancar = document.getElementById('btnLancar');
    btnLancar.disabled = true;
    btnLancar.textContent = 'Enviando...';
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'processar_despesa.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        btnLancar.disabled = false;
        btnLancar.textContent = 'Lançar Despesa';
        
        if (xhr.status === 200) {
            try {
                const resposta = JSON.parse(xhr.responseText);
                if (resposta.success) {
                    alert('Despesa cadastrada com sucesso!');
                    document.getElementById('descricao').value = '';
                    document.getElementById('valor').value = '';
                } else {
                    alert('Erro: ' + resposta.message);
                }
            } catch (e) {
                alert('Resposta do servidor inválida');
                console.error('Erro ao parsear JSON:', e);
            }
        } else {
            alert('Erro na comunicação com o servidor (Status: ' + xhr.status + ')');
        }
    };
    
    xhr.onerror = function() {
        btnLancar.disabled = false;
        btnLancar.textContent = 'Lançar Despesa';
        alert('Erro de conexão com o servidor');
    };
    
    const dados = `descricao=${encodeURIComponent(descricao)}&valor=${encodeURIComponent(valor)}`;
    xhr.send(dados);
}