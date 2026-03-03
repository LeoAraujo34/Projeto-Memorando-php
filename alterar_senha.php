<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alteração de Senha</title>
    <link rel="stylesheet" href="alterar_senha.css">
</head>
<body>
    <div class="trocadesenha-container">
        <h1>ALTERAÇÃO DE SENHA</h1>

        <form>
            <label for="rf">Senha atual:</label>
            <input type="text" id="rf" name="rf" placeholder="(Digite a senha atual)">
            <label for="senha">Nova senha:</label>
            <input type="password" id="senha" name="senha" placeholder="(Digite a nova senha)">
            <label for="senha">Confirme a senha:</label>
            <input type="password" id="senha" name="senha" placeholder="(Repita a nova senha)">
            <div class="botoes">
                <button type="submit">Confirmar</button>
                <button type="reset" class="btn-limpar">Limpar</button>
                <button type="button" class="btn-voltar" onclick="window.location.href='login.php'">Voltar</button>
            </div>
        </form>
    </div>
</body>
</html>