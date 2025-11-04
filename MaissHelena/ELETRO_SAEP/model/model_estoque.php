<?php
    require_once "../config/db.php";
    require_once "model_logs.php";

    class Estoque{
        public function adicionar_estoque($quantidade, $emite_alerta, $fornecedor, $fk_produto_id) {
            $conn = Database::getConnection();
            $insert = $conn->prepare("INSERT INTO Estoque (ESTQ_QUANTIDADE, ESTQ_EMITE_ALERTA, ESTQ_FORNECEDOR, FK_PRODUTO_ID) VALUES (?, ?, ?, ?)");
            $insert->bind_param("issi", $quantidade, $emite_alerta, $fornecedor, $fk_produto_id);
            $success = $insert->execute(); 
            $insert->close();
            return $success;
        }

        public function atualizar_estoque($quantidade, $emite_alerta, $fk_produto_id, $fk_usu_id) {
            $conn = Database::getConnection();
            $update = $conn->prepare("UPDATE Estoque SET ESTQ_QUANTIDADE = ?, ESTQ_EMITE_ALERTA = ? WHERE FK_PRODUTO_ID = ?");
            $update->bind_param("isi", $quantidade, $emite_alerta, $fk_produto_id);
            $success = $update->execute();

            if($success){
                $logs = new Logs();
                $logs->cadastrar_logs("Produto <br> ID: ".$fk_produto_id." <br> AÇÃO: Estoque editado <br> NOVA QTD: ".$quantidade."<br> ID USUÁRIO: ".$fk_usu_id);
            }
            $update->close();
            return $success;
        }
    }
?>