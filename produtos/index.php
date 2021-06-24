<?php
require("../database/conexao.php");

$sql = " SELECT p.*, c.descricao as categoria FROM tbl_produto p INNER JOIN tbl_categoria c ON p.categoria_id = c.id ORDER BY p.id DESC ";

$resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));;




// $sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
// INNER JOIN tbl_categoria c ON p.categoria_id = c.id
// WHERE p.descricao LIKE '%?%'
// OR c.descricao LIKE '%?%'
// ORDER BY p.id DESC";

$pesquisar = $_GET["pesquisar"];


$pesquisa = isset($_GET["pesquisar"]) ? $_GET["pesquisar"] : null;
if($pesquisa) {

    $sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
    INNER JOIN tbl_categoria c ON p.categoria_id = c.id
    WHERE p.descricao LIKE '%$pesquisar'%'
    OR c.descricao LIKE '$pesquisar'%'
    ORDER BY p.id DESC";

}else{

    $sql = " SELECT p.*, c.descricao as categoria FROM tbl_produto p INNER JOIN tbl_categoria c ON p.categoria_id = c.id ORDER BY p.id DESC ";

}
$pesquisar = $_GET["pesquisar"];
$result_pesquisa = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
INNER JOIN tbl_categoria c ON p.categoria_id = c.id
WHERE p.descricao LIKE '%$pesquisar'%'
OR c.descricao LIKE '$pesquisar'%'
ORDER BY p.id DESC";
$resultado_pesquisa = mysqli_query($conexao, $result_pesquisa);



if(isset($_GET['pesquisar'])){

    echo $_GET['pesquisar'];

}
    //você não pode fazer esse redirecionamento, se não fica num loop infinito, sempre redirecionando para mesma página.
    // header("location: index.php");
    // exit();




// percorrer os resultados, mostrando um card para cada produto

// mostrar a imagem do produto (que veio do banco)

//mostrar o valor do produto

//mostrar a descrição do produto

//mostrar a categoria do produto

//DESAFIO: mostrar a opção de parcelamento
//SE O VALOR > 1000, parcelar em até 12x
//SE NÃO, parcelar em até 6x






//agora é fazer o sql e percorrer os resultados, usa como exemplo a listagem da tela de categorias

//tenta fazer

//blz????

//tem coisa que passei para vcs que vc ainda não colocou aqui.. como o $sql... pega la no chat.
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles-global.css" />
    <link rel="stylesheet" href="./produtos.css" />
    <title>Administrar Produtos</title>
</head>

<body>
    <?php
    include("../componentes/header/header.php");
    ?>
    <div class="content">
        <div style="position: absolute; top: 0; right: 0;">
            <?php
            if (isset($_SESSION["erros"])) {
                echo $_SESSION["erros"][0];
            }

            if (isset($_SESSION["mensagem"])) {
                echo $_SESSION["mensagem"];
            }

            unset($_SESSION["erros"]);
            unset($_SESSION["mensagem"]);
            ?>
        </div>
        <section class="produtos-container">
            <?php
            //autorização

            //se o usuário estiver logado, mostrar os botões
            if (isset($_SESSION["usuarioId"])) {
            ?>
                <header>
                    <button onclick="javascript:window.location.href ='./novo/'">Novo Produto</button>
                    <button>Adicionar Categoria</button>
                </header>
            <?php
            }
            ?>
            <main>
                <?php
                while ($produto = mysqli_fetch_array(($resultado))) { {



                        $valorDesconto = $produto["desconto"] / 100;
                        $descontoFinal = $produto["valor"] * $valorDesconto;
                        $valorDesconto = $valorDesconto * 100;

                        $produto["valor"] = $produto["valor"] - $descontoFinal;

                        $qtdeParcelas = $produto["valor"] > 1000 ? 12 : 6;
                        $valorParcela = $produto["valor"] / $qtdeParcelas;
                    }
                ?>
                    <article class="card-produto">
                        <figure>
                            <img src=" fotos/<?= $produto["imagem"] ?>" />
                        </figure>
                        <section>
                            <span class="preco">R$ <?= number_format($produto["valor"], 2, ",", ".") ?>

                                <em><?= $valorDesconto ?> % off</em>

                            </span>
                            <span class="parcelamento">ou em

                                <em><?= $qtdeParcelas ?>x R$<?= number_format($valorParcela, 2, ",", ".") ?> sem juros</em>

                            </span>
                            <span class="descricao"><?= $produto["descricao"] ?></span>
                            <span class="categoria">
                                <em><?= $produto["categoria"] ?> </em>
                            </span>
                        </section>
                        <footer>

                        </footer>
                    </article>
                <?php
                }
                ?>


            </main>
        </section>
    </div>
    <footer>
        SENAI 2021 - Todos os direitos reservados
    </footer>
</body>

</html>