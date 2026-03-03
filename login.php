<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rf = $_POST['rf'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $rf_checked = 'admin';
    $senha_checked = '1234';

    if ($rf === $rf_checked && $senha === $senha_checked) {
        $_SESSION['usuario'] = $rf;
        header('Location: index.php');
        exit;
    } else {
        $erro = 'RF ou senha incorretos!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área de Login</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="login-container">
        <h1>LOGIN</h1>
        <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
        <form action="" method="POST">
            <label for="rf">RF:</label>
            <input type="text" id="rf" name="rf" placeholder="(Digite o RF)" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="(Digite a senha)" required>
            
            <button type="button" class="btn-trocar" onclick="window.location.href='alterar_senha.php'">Trocar a senha</button>
            <button type="submit">LOGIN</button>
        </form>
    </div>
</body>
</html>