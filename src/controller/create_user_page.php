<?php
require('../utils/load_twig.php');
require('../utils/erros.php');

$view = $twig->load('create_user.html');

$errorValue = (int) $_GET["erro"];


$errorMsg = $error[$errorValue] ?? "";

echo $view->render(['title' => 'Cadastro De Usuario', 'Erro' => $error[$errorValue] ?? ""]);