<?php
class ipaq {
    
    public function calcularMETs($dias, $minutos, $met) {
        return $dias * $minutos * $met;
    }
    
    public function calcular($dados) {
        $met_caminhada = $this->calcularMETs($dados['dias_caminhada'], $dados['minutos_caminhada'], 3.3);
        $met_moderada  = $this->calcularMETs($dados['dias_moderada'], $dados['minutos_moderada'], 4.0);
        $met_vigorosa  = $this->calcularMETs($dados['dias_vigorosa'], $dados['minutos_vigorosa'], 8.0);
        $met_total = $met_caminhada + $met_moderada + $met_vigorosa;
        
        $nivel = $this->classificar($dados, $met_total);
        
        return [
            'met_caminhada' => round($met_caminhada),
            'met_moderada'  => round($met_moderada),
            'met_vigorosa'  => round($met_vigorosa),
            'met_total'     => round($met_total),
            'nivel'         => $nivel
        ];
    }
    
    private function classificar($dados, $met_total) {
        $vig_dias = $dados['dias_vigorosa'];
        $vig_min  = $dados['minutos_vigorosa'];
        $mod_dias = $dados['dias_moderada'];
        $mod_min  = $dados['minutos_moderada'];
        
        if (($vig_dias >= 5 && $vig_min >= 30) ||
            ($vig_dias >= 3 && $vig_min >= 20 && $mod_dias >= 5 && $mod_min >= 30)) {
            return "Muito Ativo";
        }
        if (($vig_dias >= 3 && $vig_min >= 20) ||
            ($mod_dias >= 5 && $mod_min >= 30) ||
            $met_total >= 600) {
            return "Ativo";
        }
        if (($vig_dias > 0 && $vig_min >= 10) ||
            ($mod_dias > 0 && $mod_min >= 10) ||
            ($dados['dias_caminhada'] > 0 && $dados['minutos_caminhada'] >= 10)) {
            return "Irregularmente Ativo";
        }
        return "Sedentário";
    }
    
    public function gerarFeedback($nivel) {
        $feedbacks = [
            'Sedentário' => [
                'mensagem' => '⚠️ Seu nível de atividade física está baixo. A OMS recomenda pelo menos 150 minutos de atividade moderada por semana. Começar com pequenas caminhadas diárias de 10 minutos já é um ótimo primeiro passo para sua saúde!',
                'dica' => 'Tente caminhar por 10 minutos após o almoço',
                'cor' => '#dc3545'
            ],
            'Irregularmente Ativo' => [
                'mensagem' => '📈 Você está no caminho certo! Sua atividade física é irregular, mas já é um começo. Tente tornar sua rotina mais consistente para obter melhores benefícios à saúde.',
                'dica' => 'Defina horários fixos para se exercitar 3x por semana',
                'cor' => '#fd7e14'
            ],
            'Ativo' => [
                'mensagem' => '✅ Parabéns! Você atende às recomendações da Organização Mundial da Saúde. Continue assim! A prática regular de atividades físicas reduz o risco de doenças cardiovasculares, diabetes e melhora sua qualidade de vida.',
                'dica' => 'Varie os exercícios para trabalhar diferentes músculos',
                'cor' => '#28a745'
            ],
            'Muito Ativo' => [
                'mensagem' => '🏆 Excelente! Você é um exemplo de dedicação à saúde e bem-estar! Seu nível de atividade física está acima das recomendações da OMS. Lembre-se de incluir dias de descanso ativo e alongamentos para prevenir lesões.',
                'dica' => 'Inclua dias de descanso ativo e alongamentos',
                'cor' => '#007bff'
            ]
        ];
        return $feedbacks[$nivel];
    }
    
    // Método para calcular calorias (pode ser usado separadamente)
    public function calcularCalorias($met_total_min, $peso) {
        // met_total_min é MET-min, dividir por 60 para horas
        $horas = $met_total_min / 60;
        return $horas * $peso;
    }
}
?>