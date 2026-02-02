document.addEventListener('DOMContentLoaded', function() {
    const formReceita = document.getElementById('formReceita');
    const btnLancar = document.getElementById('btnLancar');
    
    if (formReceita) {
        formReceita.addEventListener('submit', function(event) {
            event.preventDefault();
            enviarReceita();
        });
    }
    
    if (btnLancar) {
        btnLancar.addEventListener('click', function(event) {
            event.preventDefault();
            enviarReceita();
        });
    }
});

function enviarReceita() {
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
    xhr.open('POST', 'processar_receita.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        btnLancar.disabled = false;
        btnLancar.textContent = 'Lançar Receita';
        
        if (xhr.status === 200) {
            try {
                const resposta = JSON.parse(xhr.responseText);
                if (resposta.success) {
                    alert('Receita cadastrada com sucesso!');
                    // Limpar os campos
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
        btnLancar.textContent = 'Lançar Receita';
        alert('Erro de conexão com o servidor');
    };
    
    const dados = `descricao=${encodeURIComponent(descricao)}&valor=${encodeURIComponent(valor)}`;
    xhr.send(dados);
}