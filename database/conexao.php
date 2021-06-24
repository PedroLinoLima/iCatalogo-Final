<?php
//Conectando com o banco de dados
const HOST = "localhost";
const USER = "root";
const PASSWORD = "bcd127";
const DATABASE = "icatalogo";
//Realiza a conexão com o banco de dados
$conexao = mysqli_connect(HOST, USER, PASSWORD, DATABASE) or die(mysqli_connect_error());

//Declarando a consulta a ser executada
//$query = "SELECT * FROM tbl_task";

//Executando a consulta utilizando a conexão criada e recebendo o resultado
//$resultado = mysqli_query($conexao, $query);
?>