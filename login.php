<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST['senha'];

    //concte ao banco de dados usando PDO
    try {
        $pdo = new PDO ("mysql:host=locallhost;dbname=autenticação","root","");
        $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e ->getMessage(      
        ));
    }

    //verifique se o usuario existe ea senha esta  correta
    $stmt = $pdo->prepare ("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt -> fetch();

    if ($user && password_verify($senha,$user["senha"])) {
        $_SESSION["usuario"] = $usuario;
        header("Location: ./src/public/dashboard.php");
    } else {
        echo "<script>alert('login falho. Verifique suas credenciais.')</script";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="pt-BR">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Página de Login</title>
</head>
<body>

<h2>Login</h2>
<form method="post">
    <input type="text" name="usuario" placeholder="Nome de Usuário" requirede> <br>
    <input type="password" name="senha" placeholder="Senha" required> <br>
    <input type="submit" value="entrar">
</form>

    
</body>
</html>