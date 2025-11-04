<?php
session_start();
// Não destrói a sessão aqui para manter a mensagem de erro
if(isset($_SESSION['usuario'])) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">       
        <title>Login - Sistema Eletrodomésticos</title>
    </head>
    <body>
        <h1>Login - Sistema de Gestão de Eletrodomésticos</h1>
        <form action="./../controller/controller_usuario.php" method="POST">
            <label>Email:</label>
            <br>
            <input type="email" id="email" name="email" placeholder="Email..." required>

            <br>
            <br>

            <label>Senha:</label>
            <br>
            <input type="password" id="senha" name="senha" placeholder="Senha..." required>

            <br>
            <br>

            <?php
                // Exibe mensagem de erro se existir
                if(isset($_SESSION['erro_login'])){
                    echo '<div class="erro">' . $_SESSION['erro_login'] . '</div>';
                    unset($_SESSION['erro_login']); // Remove a mensagem após exibir
                }
            ?>

            <br>

            <input type="submit" id="login" name="login" value="Acessar">
        </form>
    </body>
</html>