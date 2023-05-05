<?php
require('../utils/load_twig.php');
require('../utils/erros.php');

$view = $twig->load('login_user.html');

$errorValue = (int) $_GET["erro"];
$errorMsg = $error[$errorValue] ?? "";

if (!isset($errorMsg)) {
    $errorMsg = "";
}



echo $view->render(['title' => 'Login', 'Erro' => $errorMsg]);