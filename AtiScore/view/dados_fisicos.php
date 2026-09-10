<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ATI Score - Dados Físicos</title>
    <link rel="stylesheet" href="../css/style_dados.css">
</head>
<body>

<div class="dashboard-container">

    <div class="sidebar">
        <div>
            <div class="logo">ATI<span>Score</span></div>
            <ul class="menu">
                <li><a href="#">🏠 Início</a></li>
                <li class="active"><a href="dados_fisicos.php">📈 Dados físicos</a></li>
                <li><a href="avaliacoes.php">📱 Avaliações</a></li>
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
        <h1>Dados físicos</h1>
        <p class="subtitle">Atualize suas informações físicas.</p>

        <form>
            <div class="form-grid">
                <div class="input-group">
                    <label>Peso (kg)</label>
                    <input type="text" value="72.0">
                </div>
                <div class="input-group">
                    <label>Altura (cm)</label>
                    <input type="text" value="175">
                </div>
                <div class="input-group">
                    <label>% de gordura</label>
                    <input type="text" value="18">
                </div>
                <div class="input-group">
                    <label>Massa muscular (kg)</label>
                    <input type="text" value="52">
                </div>
                <div class="input-group">
                    <label>Cintura (cm)</label>
                    <input type="text" value="78">
                </div>
                <div class="input-group">
                    <label>Quadril (cm)</label>
                    <input type="text" value="94">
                </div>
                <div class="input-group">
                    <label>Peito (cm)</label>
                    <input type="text" value="101">
                </div>
                <div class="input-group">
                    <label>Braço (cm)</label>
                    <input type="text" value="36">
                </div>
            </div>

            <div class="btn-container">
                <button type="button" class="btn-primary">Salvar alterações</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>