<?php
session_start();
require("../database/conexao.php");

function validaCampos()
{
        $erros = [];
        if (!isset($_POST["descricao"]) || $_POST["descricao"] == "") {
                $erros[] = "O campo descrição é obrigatório";
        }
        return $erros;
}

switch ($_POST["acao"]) {
        case "inserir":
                if (isset($_POST["descricao"])) {

                        //receber os campos do formulário
                        $tarefa = $_POST["descricao"];

                        //mostrar o sql de insert
                        $sqlDescricao = "INSERT INTO tbl_categoria (descricao) VALUES ('$tarefa')";

                        //executar o sql de insert
                        $resultado = mysqli_query($conexao, $sqlDescricao);

                        if ($resultado) {
                                $_SESSION["mensagem"] = "Categoria inserida com sucesso";
                        } else {
                                $_SESSION["mensagem"] = "Ops, houve algum erro";
                        }


                        header("location: index.php");
                        break;
                }




        case "deletar":
                if (isset($_POST["categoriaId"])) {
                        $categoriaId = $_POST["categoriaId"];
                        //declarar o sql de delete

                        $sqlDelete = " DELETE FROM tbl_categoria WHERE id = ('$categoriaId') ";

                        //executar o sql
                        $resultado = mysqli_query($conexao, $sqlDelete);
                        
                        //verificar se deu certo
                        if($resultado){
                                $_SESSION["mensagem"] = "Categoria deletada com sucesso";
                        }else{
                                $_SESSION["mensagem"] = "Ops, erro ao excluir";
                        }

                        //redirecionar para tela de categorias com uma mensagem
                        header('location: index.php');
                        
        
                }
                break;
}
