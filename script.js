let grafico = null;

function getParameterByName(name) {
    const params = new URLSearchParams(window.location.search);
    return params.get(name);
}

const mensagem = getParameterByName('mensagem');
if (mensagem) {
    const div = document.getElementById('mensagemLogin');
    div.textContent = '✅ ' + decodeURIComponent(mensagem);
    div.style.display = 'block';

    setTimeout(() => {
        div.style.display = 'none';
        window.history.replaceState({}, document.title, window.location.pathname);
    }, 3000);
}

function checkLoginStatus() {
    const usuario = sessionStorage.getItem('usuario');
    if (usuario) {
        document.getElementById('userInfo').style.display = 'flex';
        document.getElementById('userWelcome').textContent = '👋 Olá, ' + usuario + '!';
    }
}

function formatCurrency(value) {
    return parseFloat(value)
        .toFixed(2)
        .replace('.', ',')
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function loadTotals() {
    fetch('get_totais.php')
        .then(res => res.json())
        .then(data => {
            let receitas = 0;
            let despesas = 0;

            if (data.success) {
                receitas = parseFloat(data.total_receitas);
                despesas = parseFloat(data.total_despesas);

                document.getElementById('totalReceitas').textContent =
                    'R$ ' + formatCurrency(receitas);
                document.getElementById('totalDespesas').textContent =
                    'R$ ' + formatCurrency(despesas);
                document.getElementById('saldoTotal').textContent =
                    'R$ ' + formatCurrency(data.saldo);
            }

            renderGrafico(receitas, despesas);
        });
}

function renderGrafico(receitas, despesas) {
    const ctx = document.getElementById('graficoReceitasDespesas');

    if (grafico) grafico.destroy();

    grafico = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Receitas', 'Despesas'],
            datasets: [{
                data: [receitas, despesas],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Receitas x Despesas'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'R$ ' + value.toLocaleString('pt-BR')
                    }
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    checkLoginStatus();
    loadTotals();
});
