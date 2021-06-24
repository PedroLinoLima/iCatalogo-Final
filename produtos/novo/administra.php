<?php

#todo arquivo que utilizar sessão precisa chamar a session_start
#inicializa a sessão no php
session_start();


#declara um vetor de erros
$erro = [];
#importa a conexão com o banco de dados

require("../../database/conexao.php");

//VALIDAÇÃO
function validarCampos()
{
    $erros = [];

    //validar se campo descrição está preenchido
    if (!isset($_POST["descricao"]) && $_POST["descricao"] == "") {
        $erros[] = "O campo descrição é obrigatório";
    }

    //validar se o campo peso está preenchido
    if (!isset($_POST["peso"]) && $_POST["peso"] == "") {
        $erros[] = "O campo peso é obrigatório";
        //validar se o campo peso é um número
    } else if (!is_numeric(str_replace(",", ".", $_POST["peso"]))) {
        $erros[] = "O campo peso deve ser um número";
    }

    //validar se o campo quantidade está preenchido
    if (!isset($_POST["quantidade"]) && $_POST["quantidade"] == "") {
        $erros[] = "O campo quantidade é obrigatório";
        //validar se o campo quantidade é um número
    } else if (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))) {
        $erros[] = "O campo quantidade deve ser um número";
    }
    //validar se o campo cor está preenchido
    if (!isset($_POST["cor"]) && $_POST["cor"] == "") {
        $erros[] = "O campo descrição é obrigatório";
    }

    //validar se o campo valor está preenchido e se é um número
    if (isset($_POST["valor"]) && $_POST["valor"] != "" && !is_numeric(str_replace(",", ".", $_POST["valor"]))) {
        $erros[] = "O campo valor deve ser um número";
    }

    //validar se o campo desconto está preenchido e se é um número
    if (isset($_POST["desconto"]) && $_POST["desconto"] != "" && !is_numeric(str_replace(",", ".", $_POST["desconto"]))) {
        $erros[] = "O campo desconto deve ser um número";
    } //retorna os erros

    //validar o campo categoria (obrigatório)
    if (!isset($_POST["categoria"]) || $_POST["categoria"] == "") {
        $erros[] = "O campo categoria é obrigatório";
    }

    //VALIDAÇÃO DE IMAGENS

    //verificar se o campo foto está vindo e se ele é uma imagem
    if ($_FILES["foto"]["error"] == UPLOAD_ERR_NO_FILE) {
        $erros[] = "O campo foto é obrigatório";

        //se houver um arquivo, porém com erro de upload
    } elseif (!isset($_FILES["foto"]) || $_FILES["foto"]["error"] != UPLOAD_ERR_OK) {
        $erros[] = "Ops, houve um erro inesperado. Verifique o arquivo e tente novamente";
    } else {
        $imagemInfo = getimagesize($_FILES["foto"]["tmp_name"]);
        //se o arquivo não for uma imagem
        if (!$imagemInfo) {
            $erros[] = "Este arquivo não é uma imagem";
        }


        //se o tamanho da imagem for maior que 2MB
        if ($_FILES["foto"]["size"] > 1024 * 1024 * 2) {
            $erros[] = "O arquivo não pode ser maior que 2MB";
        }
        //se a imagem não for quadrada [--DESAFIO--]

        $width = $imagemInfo[0];
        $height = $imagemInfo[1];
        if ($width != $height) {
            $erros[] = "A imagem precisa ser quadrada";
        }
    }


    return $erros;
}



//podemos salvar no banco de dados o nome novo do arquivo $newFileName

//para que possamos mostra-lo para o usuário futuramente

//da seguinte forma

//chamamos a função de validação para verificar se tem erros
$erros = validarCampos();

//se houver erros
if (count($erros) > 0) {

    #incluimos um campo erros na sessão e atribuimos um vetor a ela
    $_SESSION["erros"] = $erros;

    //redireciona para pagina do formulário
    header("location: ../novo/index.php");

    exit();
}

//se houver o envio do fomulário com uma tarefa
if (isset($_POST["descricao"]) && isset($_POST["peso"]) && isset($_POST["quantidade"]) && isset($_POST["cor"]) && isset($_POST["tamanho"]) && isset($_POST["valor"]) && isset($_POST["desconto"])) {
    $descricao = $_POST["descricao"];
    #precisamos trocar a virgula do decimal por ponto
    $peso = str_replace(",", ".", $_POST["peso"]);
    $quantidade = $_POST["quantidade"];
    $cor = $_POST["cor"];
    $tamanho = $_POST["tamanho"];
    $peso = str_replace(",", ".", $valor = $_POST["valor"]);

    $desconto = $_POST["desconto"];
    $categoriaId = $_POST["categoria"];

    //pegamos o nome original do arqvuio
    $fileName = $_FILES["foto"]["name"];

    //extraimos do nome original a extensão
    $extensao = pathinfo($fileName, PATHINFO_EXTENSION);

    //geramos um novo nome unico utilizando o unix timestamp
    $newFileName = md5(microtime()) . ".$extensao";


    //daqui pra baixo salvamos o arquivo.

    //movemos a foto para a pasta fotos dentro de produtos
    move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$newFileName");

    //declara o SQL de inserção
    $sqlInsert = "INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', '$valor', '$desconto', '$newFileName', $categoriaId)";

    //executa o SQL
    //verificar se deu certo
    $resultado = mysqli_query($conexao, $sqlInsert) or die(mysqli_error($conexao));

    if ($resultado) {
        //se deu certo, redireciona para o arquivo de listagem
        $mensagem = "Produto inserido com sucesso!";
    } else {
        //se não der certo, exibe um erro para o usuário
        $mensagem = "Erro ao inserir o produto!";
    }
    $_SESSION["mensagem"] = $mensagem;
    
    //redirecionar para tela de listagem (index.php) com a mensagem
    header("location: ../index.php");
}

