<?php
    require_once "../config/db.php";

    class Usuario{
        public function buscar_usuario($email, $senha) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT * FROM Usuario WHERE USU_EMAIL = ? AND USU_SENHA = ?");
            $select->bind_param("ss", $email, $senha);
            $select->execute();
            $resultado = $select->get_result();
            
            // Verifica se encontrou algum usuário
            if($resultado->num_rows > 0) {
                return $resultado->fetch_assoc();
            } else {
                return false;
            }
        }
    }
?>