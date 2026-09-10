<?php 
if (!isset($_SESSION)) { session_start(); } 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ATIScore - Criar sua conta</title>
  <link rel="stylesheet" href="../css/style_cadastro.css">
</head>
<body>

  <main class="container">
    <div class="card">
      
      <div class="logo">
        <a href="../index.php"> <span>ATI</span>Score</a>
      </div>

      <h2>Criar sua conta</h2>
      <p class="subtitle">Preencha os dados abaixo para começar.</p>
      
      <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert success"><?php echo $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?></div> 
      <?php endif; ?>
        
      <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="alert error"><?php echo $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?></div>
      <?php endif; ?>
        
      <form action="../model/inserircadastro.php" method="POST" enctype="multipart/form-data" name="cadastro">
        
        <div class="form-group">
          <label for="nome">Nome completo</label>
          <input type="text" id="nome" name="nome" placeholder="Digite seu nome">
        </div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="seu@email.com">
        </div>

        <div class="form-group">
          <label for="senha">Senha</label>
          <div class="input-password-wrapper">
            <input type="password" id="senha" name="senha" placeholder="••••••••">
            <button type="button" class="toggle-password" onclick="toggleSenha()" aria-label="Mostrar senha">
              <svg id="eye-icon" width="18" height="18" fill="none" stroke="#9CA3AF" stroke-width="2" viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </button>
          </div>
        </div>
       

        <button type="submit" class="btn-primary" name="Cadastrar">Cadastrar-se</button>
      </form>
      
      <p class="footer-text">
        Já tem uma conta? <a href="../view/login.php">Entrar</a>
      </p>

    </div>
  </main>
  
  <script>
    function toggleSenha() {
      const inputSenha = document.getElementById('senha');
      const eyeIcon = document.getElementById('eye-icon');
  
      if (inputSenha.type === 'password') {
        inputSenha.type = 'text';
        eyeIcon.innerHTML = `
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
          <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
      } else {
        inputSenha.type = 'password';
        eyeIcon.innerHTML = `
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
          <circle cx="12" cy="12" r="3"></circle>
        `;
      }
    }
  </script>
</body>
</html>
