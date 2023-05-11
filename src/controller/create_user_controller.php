<?php
session_start();
require("../model/User.php");
require("../model/Document.php");

if (isset($_SESSION["auth"])) {
    header("location: ./home_page.php");
}

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];


$isError = validar_dados($name, $email, $password);

if ($isError[0]) {
    return header("location: ./create_user_page.php?erro={$isError[0]}");
}






function validar_dados($name, $email, $password)
{
    $erros = array(); // Array para armazenar erros de validação

    // Validar nome
    if (empty($name)) {
        $erros[] = "1";
    } elseif (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
        $erros[] = "2";
    }

    // Validar e-mail
    if (empty($email)) {
        $erros[] = "3";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "4";
    }

    // Validar senha
    if (empty($password)) {
        $erros[] = "5";
    } elseif (strlen($password) < 8) {
        $erros[] = "6";
    }

    return $erros; // Retorna o array de erros (se houver)
}
