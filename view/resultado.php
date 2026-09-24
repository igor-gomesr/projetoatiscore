<?php
require_once '../factory/auth.php';
require_once '../funcao/ipaq.php';

$mensagem = '';
$tipo_mensagem = '';

// Processar objetivo (POST apenas com objetivo)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['objetivo']) && !isset($_POST['dias_vigorosa'])) {
    $objetivo = $_POST['objetivo'];
    if ($usuarioObj->atualizarObjetivo($_SESSION['usuario_id'], $objetivo)) {
        $_SESSION['mensagem'] = "Objetivo atualizado para " . ($objetivo == 'perder' ? 'Emagrecer' : ($objetivo == 'ganhar' ? 'Ganhar Peso' : 'Manter Peso')) . "!";
        $_SESSION['tipo_mensagem'] = 'success';
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar objetivo.";
        $_SESSION['tipo_mensagem'] = 'danger';
    }
    header("Location: resultado.php");
    exit();
}

// Exibir mensagem se existir na sessão
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo_mensagem = $_SESSION['tipo_mensagem'];
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
}

// Determinar se há dados de questionário enviados (nova avaliação)
$temQuestionario = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dias_vigorosa']));

if ($temQuestionario) {
    // Processar nova avaliação
    $dados = [
        'dias_vigorosa'   => (int)$_POST['dias_vigorosa'],
        'minutos_vigorosa'=> (int)$_POST['minutos_vigorosa'],
        'dias_moderada'   => (int)$_POST['dias_moderada'],
        'minutos_moderada'=> (int)$_POST['minutos_moderada'],
        'dias_caminhada'  => (int)$_POST['dias_caminhada'],
        'minutos_caminhada'=> (int)$_POST['minutos_caminhada'],
        'minutos_sentado' => (int)$_POST['minutos_sentado']
    ];

    $peso = isset($_POST['peso']) && $_POST['peso'] > 0 ? (float)$_POST['peso'] : $peso;

    foreach($dados as $key => $val) {
        if($val < 0) $dados[$key] = 0;
        if(strpos($key, 'dias') !== false && $val > 7) $dados[$key] = 7;
        if(strpos($key, 'minutos') !== false && $val > 1440) $dados[$key] = 1440;
    }

    $calculator = new IPAQCalculator();
    $resultado = $calculator->calcular($dados);
    $feedback = $calculator->gerarFeedback($resultado['nivel']);

    $calorias_caminhada = $resultado['met_caminhada'] * ($peso / 60);
    $calorias_moderada  = $resultado['met_moderada']  * ($peso / 60);
    $calorias_vigorosa  = $resultado['met_vigorosa']  * ($peso / 60);
    $calorias_semana    = $resultado['met_total']    * ($peso / 60);
    $calorias_dia_exercicio = $calorias_semana / 7;

    // Salvar no banco
    $questionario = new Questionario();
    $dadosSalvar = [
        'usuario_id' => $_SESSION['usuario_id'],
        'dias_vigorosa' => $dados['dias_vigorosa'],
        'minutos_vigorosa' => $dados['minutos_vigorosa'],
        'dias_moderada' => $dados['dias_moderada'],
        'minutos_moderada' => $dados['minutos_moderada'],
        'dias_caminhada' => $dados['dias_caminhada'],
        'minutos_caminhada' => $dados['minutos_caminhada'],
        'minutos_sentado' => $dados['minutos_sentado'],
        'met_caminhada' => $resultado['met_caminhada'],
        'met_moderada' => $resultado['met_moderada'],
        'met_vigorosa' => $resultado['met_vigorosa'],
        'met_total' => $resultado['met_total'],
        'nivel' => $resultado['nivel']
    ];
    $questionario->salvar($dadosSalvar);

    // Atualizar peso se informado
    if(isset($_POST['peso']) && $_POST['peso'] > 0) {
        $usuarioObj->atualizarPeso($_SESSION['usuario_id'], $peso);
        $_SESSION['usuario_peso'] = $peso;
    }

    // Após salvar, recarrega a página para exibir os dados da nova avaliação
    header("Location: resultado.php");
    exit();
}

// Se não há nova avaliação, buscar a última avaliação do banco
$questionario = new Questionario();
$ultima = $questionario->buscarUltimo($_SESSION['usuario_id']);

if (!$ultima) {
    header("Location: questionario.php");
    exit();
}

// Usar os dados da última avaliação
$dados = [
    'dias_vigorosa'   => $ultima['dias_vigorosa'],
    'minutos_vigorosa'=> $ultima['minutos_vigorosa'],
    'dias_moderada'   => $ultima['dias_moderada'],
    'minutos_moderada'=> $ultima['minutos_moderada'],
    'dias_caminhada'  => $ultima['dias_caminhada'],
    'minutos_caminhada'=> $ultima['minutos_caminhada'],
    'minutos_sentado' => $ultima['minutos_sentado']
];

$calculator = new IPAQCalculator();
$resultado = [
    'met_caminhada' => $ultima['met_caminhada'],
    'met_moderada'  => $ultima['met_moderada'],
    'met_vigorosa'  => $ultima['met_vigorosa'],
    'met_total'     => $ultima['met_total'],
    'nivel'         => $ultima['nivel']
];
$feedback = $calculator->gerarFeedback($ultima['nivel']);

$calorias_caminhada = $resultado['met_caminhada'] * ($peso / 60);
$calorias_moderada  = $resultado['met_moderada']  * ($peso / 60);
$calorias_vigorosa  = $resultado['met_vigorosa']  * ($peso / 60);
$calorias_semana    = $resultado['met_total']    * ($peso / 60);
$calorias_dia_exercicio = $calorias_semana / 7;

$objetivoAtual = $usuarioObj->buscarObjetivo($_SESSION['usuario_id']);

// Dicas para cada objetivo (20 cada)
$dicas_perder = [
    "Diminua o consumo de açúcar e alimentos ultraprocessados.",
    "Aumente a ingestão de fibras (frutas, verduras, legumes).",
    "Beba pelo menos 2 litros de água por dia.",
    "Pratique exercícios aeróbicos 3 a 5 vezes por semana.",
    "Evite ficar mais de 4 horas sem se alimentar.",
    "Durma de 7 a 8 horas por noite.",
    "Inclua proteínas magras em todas as refeições.",
    "Reduza o tamanho das porções, mas não pule refeições.",
    "Caminhe 30 minutos após o almoço.",
    "Evite bebidas alcoólicas e refrigerantes.",
    "Mastigue devagar e aprecie os alimentos.",
    "Use escadas em vez do elevador.",
    "Anote tudo o que come por 3 dias para identificar excessos.",
    "Faça refeições em pratos menores.",
    "Inclua gorduras boas (azeite, abacate, castanhas).",
    "Evite frituras; prefira alimentos grelhados ou assados.",
    "Controle o estresse com meditação ou respiração.",
    "Faça atividade física em horários que você tem mais disposição.",
    "Consulte um nutricionista para um plano personalizado.",
    "Celebre pequenas conquistas semanais."
];

$dicas_ganhar = [
    "Aumente a ingestão calórica com alimentos nutritivos (castanhas, abacate).",
    "Inclua fontes de proteína em todas as refeições.",
    "Faça de 5 a 6 refeições por dia.",
    "Treine com pesos para estimular o ganho de massa muscular.",
    "Durma bem (7-9 horas) para recuperação muscular.",
    "Beba shakes hipercalóricos (com frutas, aveia, leite).",
    "Não pule o café da manhã.",
    "Incremente as refeições com azeite, queijos e oleaginosas.",
    "Evite atividades aeróbicas excessivas.",
    "Descanse entre os treinos.",
    "Consuma carboidratos de qualidade (batata doce, arroz integral).",
    "Mantenha um diário alimentar para garantir calorias suficientes.",
    "Use suplementos como whey protein se necessário.",
    "Aumente gradualmente a carga nos exercícios.",
    "Evite refeições muito líquidas que saciam rápido.",
    "Inclua fontes de gorduras saudáveis.",
    "Faça refeições preparadas em casa com mais frequência.",
    "Evite o estresse crônico, que pode atrapalhar o ganho de peso.",
    "Consulte um profissional de educação física.",
    "Tenha paciência; ganho de massa muscular é um processo lento."
];

$dicas_manter = [
    "Mantenha uma alimentação balanceada e variada.",
    "Pratique atividades físicas regularmente (150 min/semana).",
    "Beba água ao longo do dia.",
    "Controle o estresse com técnicas de relaxamento.",
    "Durma de 7 a 8 horas por noite.",
    "Evite dietas radicais.",
    "Faça check-ups periódicos.",
    "Mantenha um diário alimentar para monitorar.",
    "Cozinhe suas próprias refeições sempre que possível.",
    "Evite o consumo excessivo de bebidas alcoólicas.",
    "Inclua exercícios de força na rotina.",
    "Varie os tipos de exercício para evitar monotonia.",
    "Coma devagar e preste atenção aos sinais de fome e saciedade.",
    "Evite passar longos períodos sem comer.",
    "Planeje as refeições da semana.",
    "Tenha um hobby ativo (dança, jardinagem, etc.).",
    "Mantenha uma rede de apoio (amigos, família).",
    "Aprenda a dizer não a excessos sociais.",
    "Use aplicativos para monitorar seus hábitos.",
    "Celebre suas conquistas semanalmente."
];

$dica_aleatoria = '';
if($objetivoAtual) {
    if($objetivoAtual == 'perder') $dica_aleatoria = $dicas_perder[array_rand($dicas_perder)];
    elseif($objetivoAtual == 'ganhar') $dica_aleatoria = $dicas_ganhar[array_rand($dicas_ganhar)];
    else $dica_aleatoria = $dicas_manter[array_rand($dicas_manter)];
}

// Cálculo do gasto diário total com Mifflin-St Jeor
if ($sexo == 'masculino') {
    $tmb = (10 * $peso) + (6.25 * $altura) - (5 * $idade) + 5;
} else {
    $tmb = (10 * $peso) + (6.25 * $altura) - (5 * $idade) - 161;
}
$calorias_dia_exercicio = $calorias_semana / 7;
$gasto_diario = $tmb + $calorias_dia_exercicio;

$recomendacao = '';
if($objetivoAtual) {
    if($objetivoAtual == 'perder') {
        $recomendacao = round($gasto_diario - 500) . ' a ' . round($gasto_diario - 300) . ' kcal/dia';
        $recomendacao .= ' (déficit de 300-500 kcal para perda de 0,5kg/semana)';
    } elseif($objetivoAtual == 'ganhar') {
        $recomendacao = round($gasto_diario + 300) . ' a ' . round($gasto_diario + 500) . ' kcal/dia';
        $recomendacao .= ' (superávit de 300-500 kcal para ganho de 0,5kg/semana)';
    } else {
        $recomendacao = round($gasto_diario - 100) . ' a ' . round($gasto_diario + 100) . ' kcal/dia';
        $recomendacao .= ' (manutenção do peso)';
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <?php if($mensagem): ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensagem; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-header text-white" style="background-color: <?php echo $feedback['cor']; ?>;">
                <h3 class="text-center">Resultado da Avaliação</h3>
                <p class="text-center mb-0"><?php echo date('d/m/Y H:i', strtotime($ultima['data_resposta'])); ?></p>
            </div>
            <div class="card-body text-center">
                <h2>Nível: <span class="badge" style="background-color: <?php echo $feedback['cor']; ?>; font-size: 1.2rem;"><?php echo $resultado['nivel']; ?></span></h2>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><strong>MET-min/semana:</strong></p>
                        <ul class="list-unstyled">
                            <li>Caminhada: <?php echo $resultado['met_caminhada']; ?></li>
                            <li>Moderada: <?php echo $resultado['met_moderada']; ?></li>
                            <li>Vigorosa: <?php echo $resultado['met_vigorosa']; ?></li>
                            <li><strong>Total: <?php echo $resultado['met_total']; ?></strong></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Calorias gastas com exercícios:</strong></p>
                        <ul class="list-unstyled">
                            <li>Caminhada: <?php echo round($calorias_caminhada, 0); ?> kcal</li>
                            <li>Moderada: <?php echo round($calorias_moderada, 0); ?> kcal</li>
                            <li>Vigorosa: <?php echo round($calorias_vigorosa, 0); ?> kcal</li>
                            <li><strong>Total na semana: <?php echo round($calorias_semana, 0); ?> kcal</strong></li>
                            <li><strong>Média diária: <?php echo round($calorias_dia_exercicio, 0); ?> kcal/dia</strong></li>
                        </ul>
                        <small>Baseado em peso: <?php echo $peso; ?> kg<br>Fórmula: MET-min × peso ÷ 60</small>
                    </div>
                </div>

                <!-- Destaque do gasto diário total -->
                <div class="alert alert-primary mt-4">
                    <h5><i class="bi bi-calculator"></i> Seu gasto energético diário total</h5>
                    <p class="mb-0">
                        <strong>Taxa metabólica basal (Mifflin‑St Jeor):</strong> <?php echo round($tmb); ?> kcal/dia<br>
                        <strong>+ Calorias gastas em exercícios (média):</strong> <?php echo round($calorias_dia_exercicio); ?> kcal/dia<br>
                        <strong class="fs-5">= Gasto diário total = <?php echo round($gasto_diario); ?> kcal/dia</strong>
                    </p>
                </div>

                <div class="alert alert-info mt-4">
                    <p><?php echo $feedback['mensagem']; ?></p>
                    <strong>💡 Dica: <?php echo $dica_aleatoria ?: "Mantenha-se ativo para uma vida saudável!"; ?></strong>
                </div>

                <?php if(!$objetivoAtual): ?>
                <hr>
                <div class="mt-4">
                    <h5>Qual é o seu objetivo?</h5>
                    <form method="POST" action="">
                        <div class="btn-group" role="group">
                            <button type="submit" name="objetivo" value="perder" class="btn btn-outline-danger">Emagrecer</button>
                            <button type="submit" name="objetivo" value="ganhar" class="btn btn-outline-success">Ganhar Peso</button>
                            <button type="submit" name="objetivo" value="manter" class="btn btn-outline-primary">Manter Peso</button>
                        </div>
                    </form>
                </div>
                <?php elseif($objetivoAtual): ?>
                <hr>
                <div class="alert alert-success mt-4">
                    <h5><i class="bi bi-trophy"></i> Para seu objetivo de <strong><?php echo ucfirst($objetivoAtual); ?></strong>:</h5>
                    <p><strong>💡 Dica:</strong> <?php echo $dica_aleatoria; ?></p>
                    <p><strong>🍽️ Recomendação calórica diária:</strong> <?php echo $recomendacao; ?></p>
                    <p><small>
                        * Cálculo baseado no gasto diário total de <?php echo round($gasto_diario); ?> kcal/dia.<br>
                        Ajuste de <?php echo ($objetivoAtual == 'perder' ? 'déficit' : ($objetivoAtual == 'ganhar' ? 'superávit' : 'manutenção')); ?> de 300-500 kcal.
                    </small></p>
                </div>
                <?php endif; ?>

                <div class="mt-4">
                    <a href="dashboard.php" class="btn btn-primary"><i class="bi bi-speedometer2"></i> Ir para Dashboard</a>
                    <a href="questionario.php" class="btn btn-success"><i class="bi bi-clipboard-check"></i> Nova Avaliação</a>
                    <a href="historico.php" class="btn btn-secondary"><i class="bi bi-clock-history"></i> Ver Histórico</a>
                </div>
            </div>
        </div>
    </div>
</div>



