<?php

session_start();
require("../model/User.php");

if (isset($_SESSION["auth"])) {
    header("location: ./home_page.php");
}

$email = $_POST['email'];
$password = $_POST['password'];

$user = new User();

$user->login($email, $password);