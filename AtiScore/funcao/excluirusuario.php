<?php
        require_once "../factory/conexao.php";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_usuario'])) {
            $conn = new Caminho();
            $pdo = $conn->getConn();

            $tipo = $_POST['tipo_usuario'];
            $id = $_POST['excluir_usuario'];

            try {
                switch ($tipo) {
                    case 'adm': $sql = "DELETE FROM tbadm WHERE id = ?"; break;
                    case 'cliente': $sql = "DELETE FROM tbcadastro WHERE id = ?"; break;
                    default: $erro = "Tipo de usuário inválido."; break;
                }

                if (!isset($erro)) {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$id]);
                    $sucesso = "Usuário excluído com sucesso!";
                }
            } catch (PDOException $e) {
                $erro = "Erro ao excluir usuário: " . $e->getMessage();
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Exclusão de Usuários - ZADHI</title>
            <link rel="stylesheet" href="../css/estilo.css">
        </head>
        <body>
            <div class="painel">
                <div class="link-container">
                    <a href="../index.php">Home</a>
                    <a href="../telas/tela_adm_zadhi.php">Painel Admin</a>
                </div>
                <h1>Exclusão de Usuários</h1>
                <?php if (!empty($sucesso)): ?>
                    <div class="alert success"><?php echo $sucesso; ?></div>
                <?php endif; ?>
                <?php if (!empty($erro)): ?>
                    <div class="alert error"><?php echo $erro; ?></div>
                <?php endif; ?>

                <?php
                $conn = new Caminho();
                $pdo = $conn->getConn();

                $tipos = [
                    'adm' => ['tabela' => 'tbadm', 'titulo' => 'Administradores', 'campo_nome' => 'adm_nome'],
                    'cliente' => ['tabela' => 'tbcadastro', 'titulo' => 'Clientes', 'campo_nome' => 'nome']
                ];

                foreach ($tipos as $tipo => $info):
                    $stmt = $pdo->query("SELECT id, {$info['campo_nome']} AS nome FROM {$info['tabela']}");
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                    <h2><?php echo $info['titulo']; ?></h2>
                    <?php if ($usuarios): ?>
                        <div class="usuario-cards">
                            <?php foreach ($usuarios as $usuario): ?>
                                <div class="card-usuario">
                                    <p><strong>ID:</strong> <?php echo $usuario['id']; ?></p>
                                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
                                    <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                        <input type="hidden" name="senha_admin" value="123">
                                        <input type="hidden" name="excluir_usuario" value="<?php echo $usuario['id']; ?>">
                                        <input type="hidden" name="tipo_usuario" value="<?php echo $tipo; ?>">
                                        <button type="submit" class="btn-excluir">EXCLUIR</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>Nenhum usuário encontrado.</p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </body>
        </html>
        