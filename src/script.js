let grafico = null;

function getParameterByName(name) {
    const params = new URLSearchParams(window.location.search);
    return params.get(name);
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
            let saldo = 0;

            if (data.success) {
                receitas = parseFloat(data.total_receitas);
                despesas = parseFloat(data.total_despesas);
                saldo = parseFloat(data.saldo);

                document.getElementById('totalReceitas').textContent =
                    'R$ ' + formatCurrency(receitas);
                document.getElementById('totalDespesas').textContent =
                    'R$ ' + formatCurrency(despesas);
                document.getElementById('saldoTotal').textContent =
                    'R$ ' + formatCurrency(saldo);
            }

            renderGrafico(receitas, despesas, saldo);
        });
}

function renderGrafico(receitas, despesas, saldo) {
    const ctx = document.getElementById('graficoReceitasDespesas');

    if (grafico) grafico.destroy();

    grafico = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Receitas', 'Despesas', 'Saldo Final'],
            datasets: [{
                data: [receitas, despesas, saldo],
                backgroundColor: ['#28a745', '#dc3545', '#6da2f9']
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Receitas x Despesas x Saldo'
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
    loadTotals();
});