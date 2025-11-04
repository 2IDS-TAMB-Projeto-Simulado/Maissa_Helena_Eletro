<?php
require_once "../model/model_estoque.php";
session_start();

if (isset($_POST['botao_atualizar'])) {
    $nova_qtd = $_POST['estoque_qtd'];
    $emite_alerta = 'Não';
    
    if($_POST['acao_estoque'] == "entrada"){
        $nova_qtd = $_POST['estoque_qtd'] + $_POST['qtd_aumentar_diminuir'];
    }
    if($_POST['acao_estoque'] == "saida"){
        $nova_qtd = $_POST['estoque_qtd'] - $_POST['qtd_aumentar_diminuir'];
        if($nova_qtd < 0){
            $nova_qtd = 0;
        }
    }
    
    // Verificar se emite alerta (estoque baixo)
    if($nova_qtd <= 5){
        $emite_alerta = 'Sim';
        echo "<script>
                alert('Estoque do produto está baixo!');
              </script>";
    }
    
    $estoque = new Estoque();
    $success = $estoque->atualizar_estoque($nova_qtd, $emite_alerta, $_POST["produto_id"], $_SESSION['usuario']['USU_ID']);

    if($success){
        echo "<script>
                alert('Estoque atualizado com sucesso!');
                window.location.href = './../view/gestao_estoque.php';
              </script>";
    } 
    else {
        echo "<script>
                alert('Falha ao atualizar o estoque!');
                window.location.href = './../view/gestao_estoque.php';
              </script>";
    }
}
?>