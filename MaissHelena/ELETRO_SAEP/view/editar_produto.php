<?php
require_once "./../controller/controller_produto.php";

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">       
        <title>Editar Produto</title>
    </head>
    <body>
        <h1>Editar Produto Eletrodoméstico</h1>
        <form action="" method="POST">
            <label>Nome:</label>
            <br>
            <input type="text" id="nome" name="nome" value="<?php echo $produto_editar["PRODUTO_NOME"]; ?>" required>

            <br><br>

            <label>Fornecedor:</label>
            <br>
            <input type="text" id="fornecedor" name="fornecedor" value="<?php echo $produto_editar["PRODUTO_FORNECEDOR"]; ?>" required>

            <br><br>

            <label>Categoria:</label>
            <br>
            <input type="text" id="categoria" name="categoria" value="<?php echo $produto_editar["PRODUTO_CATEGORIA"]; ?>" required>

            <br><br>

            <label>Potência:</label>
            <br>
            <input type="text" id="potencia" name="potencia" value="<?php echo $produto_editar["PRODUTO_POTENCIA"]; ?>" required>

            <br><br>

            <label>Garantia:</label>
            <br>
            <input type="text" id="garantia" name="garantia" value="<?php echo $produto_editar["PRODUTO_GARANTIA"]; ?>" required>

            <br><br>

            <label>Consumo Energético:</label>
            <br>
            <input type="text" id="consumo_energetico" name="consumo_energetico" value="<?php echo $produto_editar["PRODUTO_CONSUMO_ENERGETICO"]; ?>" required>

            <br><br>

            <label>Prioridade de Reposição:</label>
            <br>
            <select id="prioridade_reposicao" name="prioridade_reposicao" required>
                <option value="Alta" <?php echo ($produto_editar["PRODUTO_PRIORIDADE_REPOSICAO"] == 'Alta') ? 'selected' : ''; ?>>Alta</option>
                <option value="Média" <?php echo ($produto_editar["PRODUTO_PRIORIDADE_REPOSICAO"] == 'Média') ? 'selected' : ''; ?>>Média</option>
                <option value="Baixa" <?php echo ($produto_editar["PRODUTO_PRIORIDADE_REPOSICAO"] == 'Baixa') ? 'selected' : ''; ?>>Baixa</option>
            </select>

            <br><br>

            <input type="submit" id="editar_produto" name="editar_produto" value="Salvar Alterações">
        </form>
        <br>
        <a href="inicial.php"><button>Voltar</button></a>
    </body>
</html>