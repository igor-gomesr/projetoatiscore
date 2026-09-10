<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ATI Score - Avaliações</title>
    <link rel="stylesheet" href="../css/style_dados.css">
</head>
<body>

<div class="dashboard-container">
    <div class="sidebar">
        <div>
            <div class="logo">ATI<span>Score</span></div>
            <ul class="menu">
                <li><a href="#">🏠 Início</a></li>
                <li><a href="dados_fisicos.php">📈 Dados físicos</a></li>
                <li class="active"><a href="avaliacoes.php">📱 Avaliações</a></li>
                <li><a href="#">⭐ Nível físico</a></li>
                <li><a href="#">📈 Evolução</a></li>
                <li><a href="#">💡 Sugestões</a></li>
                <li><a href="#">📄 Relatórios</a></li>
                <li><a href="#">📦 Treinos</a></li>
            </ul>
        </div>
        <a href="#" class="sair-link">Sair</a>
    </div>

    <div class="main-content">
        <h1>Iniciar avaliação</h1>
        <p class="subtitle">Complete as etapas abaixo para gerar um novo relatório de desempenho.</p>

        <div class="steps-card">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-info">
                    <h3>Informações iniciais</h3>
                    <p>Histórico de saúde, rotina e objetivos gerais.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-info">
                    <h3>Questionário</h3>
                    <p>Perguntas de múltipla escolha sobre hábitos diários.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-info">
                    <h3>Medidas corporais</h3>
                    <p>Registro de peso, altura, circunferências e dobras.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-info">
                    <h3>Desempenho físico</h3>
                    <p>Testes rápidos de resistência e força.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">5</div>
                <div class="step-info">
                    <h3>Revisão e conclusão</h3>
                    <p>Envio de respostas para cálculo final.</p>
                </div>
            </div>
        </div>

        <div class="btn-container" style="margin-top: 25px;">
            <button type="button" class="btn-primary">Começar avaliação</button>
        </div>
    </div>
</div>

</body>
</html>