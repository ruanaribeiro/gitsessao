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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tela de login</title>
</head>
<body>
    
</body>
</html>