<?php
require('./utils/load_twig.php');
require('./utils/erros.php');

$view = $twig->load('create_user.html');

$errorMsg = "";

if ($hasErrors) {
  $errorId = explode("=", $hasErrors)[1];
  $errorMsg = $error[$errorId] ?? "";
}


echo $view->render(['title' => 'Cadastro De Usuario', 'Erro' => $errorMsg ?? ""]);
