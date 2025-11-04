<?php
require_once "../config/db.php";

class Logs {
    // Cadastra um novo log no sistema
    public function cadastrar_logs($descricao) {
        $conn = Database::getConnection();
        $insert = $conn->prepare("
            INSERT INTO LOGS (LOG_DESCRICAO, LOG_DATA_HORA)
            VALUES (?, NOW())
        ");
        $insert->bind_param("s", $descricao);
        $success = $insert->execute();
        $insert->close();
        return $success;
    }
}
?>
