<?php
require_once '../factory/auth.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATIScore - Questionário IPAQ</title>
    <link rel="stylesheet" href="../css/style_questionario.css">
</head>
<body>

<div class="dashboard-container">

    <div class="sidebar">
        <div>
            <div class="logo"><a href="../index.php"> <span>ATI</span>Score</a></div>
            <ul class="menu">
                <li class="active"><a href="avaliacoes.php">Avaliações</a></li>
            </ul>
        </div>
        <a href="../index.php" class="sair-link">Sair</a>
    </div>

    <div class="main-content">
        <h1>Questionário IPAQ - Versão Curta</h1>
        <p class="subtitle">Pense nos últimos 7 dias contínuos e responda as perguntas abaixo.</p>

        <div class="info-box">
            <strong>Seus dados:</strong> Idade: <?php echo $idade ?: 'não informada'; ?> anos | Peso: <?php echo $peso; ?> kg
        </div>

        <form id="formQuestionario" action="resultados.php" method="POST">

            <div class="question-block">
                <h3>Peso atual (kg)</h3>
                <div class="form-grid form-grid-single">
                    <div class="input-group">
                        <label for="peso">Peso (kg)</label>
                        <input type="number" name="peso" id="peso" step="0.1" min="0" value="<?php echo $peso; ?>" required>
                        <small>Seu peso pode ter mudado, atualize se necessário.</small>
                    </div>
                </div>
            </div>

            <!-- Atividade VIGOROSA -->
            <div class="question-block">
                <h3>Atividade Física VIGOROSA</h3>
                <p class="question-desc">Exemplos: corrida, natação rápida, musculação intensa, esportes competitivos.</p>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="diasintenso">Dias por semana</label>
                        <input type="number" name="diasintenso" id="diasintenso" min="0" max="7" value="0" required>
                    </div>
                    <div class="input-group">
                        <label for="horasintenso">Horas por dia</label>
                        <input type="number" id="horasintenso" min="0" max="23" value="0" step="1">
                    </div>
                    <div class="input-group">
                        <label for="minutosintenso">Minutos por dia (0-59)</label>
                        <input type="number" id="minutosintenso" min="0" max="59" value="0">
                    </div>
                </div>
            </div>

            <!-- Atividade MODERADA -->
            <div class="question-block">
                <h3>Atividade Física MODERADA</h3>
                <p class="question-desc">Exemplos: caminhada rápida, dança, bicicleta leve, jardinagem.</p>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="diasmoderada">Dias por semana</label>
                        <input type="number" name="diasmoderada" id="diasmoderada" min="0" max="7" value="0" required>
                    </div>
                    <div class="input-group">
                        <label for="horasmoderada">Horas por dia</label>
                        <input type="number" id="horasmoderada" min="0" max="23" value="0">
                    </div>
                    <div class="input-group">
                        <label for="minutosmoderada">Minutos por dia (0-59)</label>
                        <input type="number" id="minutosmoderada" min="0" max="59" value="0">
                    </div>
                </div>
            </div>

            <!-- Caminhada -->
            <div class="question-block">
                <h3>Caminhada</h3>
                <p class="question-desc">Considere caminhadas como forma de transporte ou lazer (no mínimo 10 minutos contínuos).</p>
                <div class="form-grid">
                    <div class="input-group">
                        <label for="diascaminhada">Dias por semana</label>
                        <input type="number" name="diascaminhada" id="diascaminhada" min="0" max="7" value="0" required>
                    </div>
                    <div class="input-group">
                        <label for="horascaminhada">Horas por dia</label>
                        <input type="number" id="horascaminhada" min="0" max="23" value="0">
                    </div>
                    <div class="input-group">
                        <label for="minutoscaminhada">Minutos por dia (0-59)</label>
                        <input type="number" id="minutoscaminhada" min="0" max="59" value="0">
                    </div>
                </div>
            </div>

            <!-- Tempo sentado -->
            <div class="question-block">
                <h3>Tempo sentado em um dia de semana</h3>
                <p class="question-desc">Inclui tempo sentado no trabalho, em casa, no transporte, etc. (exceto dormir).</p>
                <div class="form-grid form-grid-single">
                    <div class="input-group">
                        <label for="horassentado">Horas por dia</label>
                        <input type="number" id="horassentado" min="0" max="23" value="0">
                    </div>
                    <div class="input-group">
                        <label for="minutossentado">Minutos por dia (0-59)</label>
                        <input type="number" id="minutossentado" min="0" max="59" value="0">
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <button type="reset" class="btn-secondary">Limpar</button>
                <button type="submit" class="btn-primary">Calcular e Analisar</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('formQuestionario').addEventListener('submit', function(e) {
    const grupos = ['vigorosa', 'moderada', 'caminhada', 'sentado'];
    grupos.forEach(grupo => {
        let horas = parseInt(document.getElementById(`horas_${grupo}`).value) || 0;
        let minutos = parseInt(document.getElementById(`minutos_${grupo}`).value) || 0;
        let totalMinutos = horas * 60 + minutos;
        let hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = `minutos_${grupo}`;
        hidden.value = totalMinutos;
        this.appendChild(hidden);
    });
});
</script>

</body>
</html>