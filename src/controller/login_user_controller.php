<?php

session_start();
require("../model/User.php");

if (isset($_SESSION["auth"])) {
    header("location: ./home_page.php");
}

$email = $_POST['email'];
$password = $_POST['password'];

$user = new User();

$userExist = $user->getUserByEmail($email);
if ($userExist) {
    header("location: ./login_user_page.php?erro=8");
};

$user->login($email, $password);

header("location: ./home_page.php");
