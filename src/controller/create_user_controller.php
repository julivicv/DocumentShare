<?php
session_start();
require("./model/User.php");

if (isset($_SESSION["auth"])) {
    header("location: /home");
}


$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];


$isError = validar_dados($name, $email, $password);

if ($isError[0]) {
    return header("location: /register?erro={$isError[0]}");
}

$newUser = new User();

$userExist = $newUser->getUserByEmail($email);

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

if ($userExist) {
    return header("location: /register?erro=8");
}

$newUser->create([
    "name" => $name,
    "email" => $email,
    "password" => $passwordHash
]);

return header("location: /login");


function validar_dados($name, $email, $password)
{
    $erros = array();
    if ($name === null) {
        $erros[] = "1";
    } elseif (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
        $erros[] = "3";
    }

    if ($email === null) {
        $erros[] = "2";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "2";
    }

    if ($password === null) {
        $erros[] = "4";
    } elseif (strlen($password) < 8) {
        $erros[] = "5";
    }

    return $erros;
}
