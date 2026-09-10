<?php
session_start(); 
require_once('../factory/conexao.php'); 

if (isset($_POST['Cadastrar'])) {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION['mensagem_erro'] = "Por favor, preencha todos os campos.";
        header('Location: ../view/cadastro.php');
        exit();
    }

    $conn = new Caminho();
    $pdo = $conn->getConn();

    $stmt_check_nome = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE nome = :nome");
    $stmt_check_nome->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt_check_nome->execute();
    $nome_existente = $stmt_check_nome->fetchColumn();

    $stmt_check_email = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
    $stmt_check_email->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_check_email->execute();
    $email_existente = $stmt_check_email->fetchColumn();

    if ($email_existente > 0) {
        $_SESSION['mensagem_erro'] = "Este email já está cadastrado. Por favor, use outro email ou faça login.";
        header('Location: ../view/cadastro.php');
        exit();
    }

    $query = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, SHA1(:senha))";
    $cadastrar = $pdo->prepare($query);   
    
    $cadastrar->bindParam(':nome', $nome, PDO::PARAM_STR);
    $cadastrar->bindParam(':email', $email, PDO::PARAM_STR);
    $cadastrar->bindParam(':senha', $senha, PDO::PARAM_STR);

    if ($cadastrar->execute()) {
        $_SESSION['mensagem_sucesso'] = "Você foi cadastrado com sucesso! Faça login para continuar.";
        header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao cadastrar. Tente novamente.";
        header('Location: ../view/cadastro.php');
        exit();
    }
} else {
    header('Location: ../view/cadastro.php');
    exit();
}
?>