<?php
session_start();
require_once('../factory/conexao.php');

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'] ?? '';
  $senha = $_POST['senha'] ?? '';

  if (empty($email) || empty($senha)) {
    $erro = "Por favor, preencha todos os campos.";
  } else {
    $conn = new Caminho();
    $pdo = $conn->getConn();

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
      $_SESSION['usuario_id'] = $usuario['id'];
      $_SESSION['usuario_nome'] = $usuario['nome'];
      header("Location: ../view/avaliacoes.php");
      exit();
    } else {
      $erro = "Email ou senha incorretos.";
    }
  }
}

if (isset($_SESSION['mensagem_sucesso'])) {
  $sucesso = $_SESSION['mensagem_sucesso'];
  unset($_SESSION['mensagem_sucesso']);
}
if (isset($_SESSION['mensagem_erro'])) {
  $erro = $_SESSION['mensagem_erro'];
  unset($_SESSION['mensagem_erro']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ATIScore - Entrar na sua conta</title>
  <link rel="stylesheet" href="../css/style_login.css">
</head>

<body>

  <main class="container">
    <div class="card">

      <div class="logo">
        <a href="../index.php"> <span>ATI</span>Score </a>
      </div>
      <?php if (!empty($sucesso)): ?>
        <div class="alert success"><?php echo $sucesso; ?></div>
      <?php endif; ?>
      <?php if (!empty($erro)): ?>
        <div class="alert error"><?php echo $erro; ?></div>
      <?php endif; ?>

      <h2>Entrar na sua conta</h2>
      <p class="subtitle">Acesse sua conta para continuar.</p>

      <form method="post">

        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="seu@email.com" required>
        </div>

        <div class="form-group">
          <label for="senha">Senha</label>
          <div class="input-password-wrapper">
            <input type="password" id="senha" name="senha" placeholder="••••••••" required>

            <button type="button" class="toggle-password" onclick="toggleSenha()" aria-label="Mostrar ou ocultar senha">
              <svg id="eye-icon" width="18" height="18" fill="none" stroke="#9CA3AF" stroke-width="2"
                viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </button>
          </div>
        </div>

        <!--  <div class="form-options">
          <label class="remember-me">
            <input type="checkbox" id="lembrar">
            <span>Lembrar senha</span>
          </label>
          <a href="#" class="forgot-password">Esqueceu sua senha?</a>
        </div> -->

        <button type="submit" class="btn-primary">Entrar</button>

      </form>

      <p class="footer-text">
        Não tem uma conta? <a href="../view/cadastro.php">Cadastrar-se</a>
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