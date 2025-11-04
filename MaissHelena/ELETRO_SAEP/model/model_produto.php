<?php
    require_once "../config/db.php";
    require_once "model_estoque.php";
    require_once "model_logs.php";

    class Produto{
        public function cadastrar_produto($nome, $fornecedor, $categoria, $potencia, $garantia, $consumo_energetico, $prioridade_reposicao, $fk_usu_id) {
            $conn = Database::getConnection();
            $insert = $conn->prepare("INSERT INTO Produto (PRODUTO_NOME, PRODUTO_FORNECEDOR, PRODUTO_CATEGORIA, PRODUTO_POTENCIA, PRODUTO_GARANTIA, PRODUTO_CONSUMO_ENERGETICO, PRODUTO_PRIORIDADE_REPOSICAO, FK_USU_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->bind_param("sssssssi", $nome, $fornecedor, $categoria, $potencia, $garantia, $consumo_energetico, $prioridade_reposicao, $fk_usu_id);
            $success = $insert->execute();

            if($success){
                $produto_id = $conn->insert_id;

                $estoque = new Estoque();
                $estoque->adicionar_estoque(0, 'Não', $fornecedor, $produto_id);

                $logs = new Logs();
                $logs->cadastrar_logs("PRODUTO <br> ID: ".$produto_id." <br> NOME: ".$nome." <br> AÇÃO: Cadastrado! <br> ID USUÁRIO: ".$fk_usu_id);
            }

            $insert->close();
            return $success;
        }

        public function listar_produtos() {
            $conn = Database::getConnection();
            $sql = "SELECT      P.PRODUTO_ID,
                                P.PRODUTO_NOME,
                                P.PRODUTO_FORNECEDOR,
                                P.PRODUTO_CATEGORIA,
                                P.PRODUTO_POTENCIA,
                                P.PRODUTO_GARANTIA,
                                P.PRODUTO_CONSUMO_ENERGETICO,
                                P.PRODUTO_PRIORIDADE_REPOSICAO,
                                E.ESTQ_QUANTIDADE,
                                E.ESTQ_EMITE_ALERTA,
                                U.USU_NOME,
                                U.USU_EMAIL
                    FROM        Produto P
                    JOIN        Usuario U ON P.FK_USU_ID = U.USU_ID
                    JOIN        Estoque E ON P.PRODUTO_ID = E.FK_PRODUTO_ID
                    ORDER BY   P.PRODUTO_NOME";
            $result = $conn->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function excluir_produto($produto_id, $fk_usu_id) {
            $conn = Database::getConnection();
            $delete = $conn->prepare("DELETE FROM Produto WHERE PRODUTO_ID = ?");
            $delete->bind_param("i", $produto_id);

            $logs = new Logs();
            $logs->cadastrar_logs("PRODUTO <br> ID: ".$produto_id." <br> AÇÃO: Excluído! <br> ID USUÁRIO: ".$fk_usu_id);
            
            $success = $delete->execute();
            $delete->close();
            return $success;
        }

        public function buscar_produto_pelo_id($id) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT        P.PRODUTO_ID,
                                                    P.PRODUTO_NOME,
                                                    P.PRODUTO_FORNECEDOR,
                                                    P.PRODUTO_CATEGORIA,
                                                    P.PRODUTO_POTENCIA,
                                                    P.PRODUTO_GARANTIA,
                                                    P.PRODUTO_CONSUMO_ENERGETICO,
                                                    P.PRODUTO_PRIORIDADE_REPOSICAO,
                                                    E.ESTQ_QUANTIDADE,
                                                    E.ESTQ_EMITE_ALERTA,
                                                    U.USU_NOME,
                                                    U.USU_EMAIL
                                        FROM        Produto P
                                        JOIN        Usuario U ON P.FK_USU_ID = U.USU_ID
                                        JOIN        Estoque E ON P.PRODUTO_ID = E.FK_PRODUTO_ID
                                        WHERE       P.PRODUTO_ID = ?
                                        ORDER BY    P.PRODUTO_NOME");
            $select->bind_param("i", $id);
            $select->execute();
            $result = $select->get_result();
            $produto = $result->fetch_all(MYSQLI_ASSOC);
            $select->close();
            return $produto;
        }

        public function editar_produto($nome, $fornecedor, $categoria, $potencia, $garantia, $consumo_energetico, $prioridade_reposicao, $produto_id, $fk_usu_id) {
            $conn = Database::getConnection();
            $update = $conn->prepare("UPDATE Produto SET PRODUTO_NOME = ?, PRODUTO_FORNECEDOR = ?, PRODUTO_CATEGORIA = ?, PRODUTO_POTENCIA = ?, PRODUTO_GARANTIA = ?, PRODUTO_CONSUMO_ENERGETICO = ?, PRODUTO_PRIORIDADE_REPOSICAO = ? WHERE PRODUTO_ID = ?");
            $update->bind_param("sssssssi", $nome, $fornecedor, $categoria, $potencia, $garantia, $consumo_energetico, $prioridade_reposicao, $produto_id);
            $success = $update->execute();

            if($success){
                $logs = new Logs();
                $logs->cadastrar_logs("PRODUTO <br> ID: ".$produto_id." <br> NOME: ".$nome." <br> AÇÃO: Editado! <br> ID USUÁRIO: ".$fk_usu_id);
            }

            $update->close();
            return $success;
        }

        public function filtrar_produto($campo) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT        P.PRODUTO_ID,
                                                    P.PRODUTO_NOME,
                                                    P.PRODUTO_FORNECEDOR,
                                                    P.PRODUTO_CATEGORIA,
                                                    P.PRODUTO_POTENCIA,
                                                    P.PRODUTO_GARANTIA,
                                                    P.PRODUTO_CONSUMO_ENERGETICO,
                                                    P.PRODUTO_PRIORIDADE_REPOSICAO,
                                                    E.ESTQ_QUANTIDADE,
                                                    E.ESTQ_EMITE_ALERTA,
                                                    U.USU_NOME,
                                                    U.USU_EMAIL
                                        FROM        Produto P
                                        JOIN        Usuario U ON P.FK_USU_ID = U.USU_ID
                                        JOIN        Estoque E ON P.PRODUTO_ID = E.FK_PRODUTO_ID
                                        WHERE       P.PRODUTO_NOME LIKE ? OR P.PRODUTO_CATEGORIA LIKE ?
                                        ORDER BY    P.PRODUTO_NOME");
            $termo = "%" . $campo . "%";
            $select->bind_param("ss", $termo, $termo);
            $select->execute();
            $result = $select->get_result();
            $produtos = $result->fetch_all(MYSQLI_ASSOC);
            $select->close();
            return $produtos;
        }
    }
?>