<?php
session_start();
require_once("factory/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ATIScore - Seu desempenho físico</title>
  <link rel="stylesheet" href="./css/style_index.css">
</head>
<body>

  <header class="navbar">
    <div class="logo">
      <span>ATI</span>Score
    </div>
    <nav class="nav-links">
      <a href="#">Recursos</a>
      <a href="#">Sobre</a>
      <a href="#">Planos</a>
      <a href="#">Contato</a>
      <a href="./view/login.php" class="btn-login">Entrar</a>
      <a href="./view/cadastro.php" class="btn-signup">Cadastrar-se</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-content">
      <h1>Seu desempenho físico.</h1>
      <p>
        Acompanhe sua evolução física com avaliações detalhadas, 
        sugestões de treinos personalizados e relatórios gerados 
        especialmente para o seu biotipo.
      </p>
      <div class="hero-buttons">
        <a href="#" class="btn-primary">Começar agora</a>
        <a href="#" class="btn-secondary">Saiba mais</a>
      </div>
    </div>
  </section>

  <!-- SEÇÃO DE RECURSOS / CARDS -->
  <section class="features-container">
    <div class="features-grid">

      <!-- Card 1 -->
      <div class="card">
        <div class="icon-box">
          <!-- Ícone Prancheta -->
          <svg width="20" height="20" fill="none" stroke="#0066FF" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <h3>Avaliações completas</h3>
        <p>Análise detalhada de composição corporal e métricas físicas.</p>
      </div>

      <!-- Card 2 -->
      <div class="card">
        <div class="icon-box">
          <!-- Ícone Gráfico -->
          <svg width="20" height="20" fill="none" stroke="#0066FF" stroke-width="2" viewBox="0 0 24 24">
            <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
          </svg>
        </div>
        <h3>Acompanhamento</h3>
        <p>Monitore sua evolução histórica através de gráficos fáceis de ler.</p>
      </div>

      <!-- Card 3 -->
      <div class="card">
        <div class="icon-box">
          <!-- Ícone Medalha / Medal -->
          <svg width="20" height="20" fill="none" stroke="#0066FF" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 15l-2 5l3-2l3 2l-2-5M12 15a7 7 0 1 0 0-14a7 7 0 0 0 0 14z"></path>
          </svg>
        </div>
        <h3>Sugestões personalizadas</h3>
        <p>Algoritmos inteligentes recomendam os treinos certos para seu objetivo.</p>
      </div>

      <!-- Card 4 -->
      <div class="card">
        <div class="icon-box">
          <!-- Ícone Documento -->
          <svg width="20" height="20" fill="none" stroke="#0066FF" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h3>Relatórios detalhados</h3>
        <p>Exporte análises em PDF para apresentar ao seu treinador.</p>
      </div>

    </div>
  </section>

</body>
</html>