<?php
include("../database/conexao.php");

$sqlSelect = "SELECT * FROM tbl_categoria ";

$resultado = mysqli_query($conexao, $sqlSelect);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles-global.css" />
    <link rel="stylesheet" href="./categoriass.css" />
    <title>Administrar Categorias</title>
</head>

<body>
    <?php
    include("../componentes/header/header.php");
    ?>
    <div class="content">
        <section class="categorias-container">
            <main>
                <input type="hidden" name="acao" value="inserir">
                <form method="POST" class="form-categoria" action="../categorias/acoes.php">
                    <h1 class="span2">Adicionar Categorias</h1>
                    <ul>
                        <?php
                        //verifica se existe erros na sessão do usuário
                        if (isset($_SESSION["erros"])) {
                            //se existir percorre os erros exbindo na tela
                            foreach ($_SESSION["erros"] as $erro) {
                        ?>
                                <li><?= $erro ?></li>
                        <?php
                            }
                            //eliminar da sessão os erros já mostrados
                            unset($_SESSION["erros"]);
                        }
                        ?>
                    </ul>
                    <div class="input-group span2">
                        <input type="hidden" name="acao" value="inserir" />
                        <label for="descricao">Descrição</label>
                        <input type="text" name="descricao" id="descricao" />
                    </div>
                    <button type="button" onclick="javascript:window.location.href = '../produtos'">Cancelar</button>
                    <button>Salvar</button>
                </form>
                <h1>Lista de Categorias</h1>
                <?php


                if (mysqli_num_rows($resultado) == 0) {
                    echo "<p style='text-align: center'>Nenhuma categoria cadastrada.</p>";
}

                while ($descricao = mysqli_fetch_array($resultado)) {
                ?>
                    <div class="card-categorias">
                        <?= $descricao["descricao"] ?>
                        <form method="POST" action="acoes.php">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="categoriaId" value="<?= $descricao['id'] ?>" />
                            <button>
                                <img src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png" />
                            </button>
                        </form>
                    </div>
                <?php
                }
                ?>
            </main>
        </section>
    </div>

    <!--
                <script lang="javascript">
                    function deletar(categoriaId){
                        document.querySelector("#categoriaId").value = categoriaId;
                        document.querySelector("#form-deletar").submit();
                    }
                -->


</body>

</html>