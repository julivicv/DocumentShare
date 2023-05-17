<?php
require('./utils/load_twig.php');
require('./utils/erros.php');
session_start();

$view = $twig->load('submit_files.html');

$errorMsg = "";

if ($hasErrors) {
  $errorId = explode("=", $hasErrors)[1];
  $errorMsg = $error[$errorId] ?? "";
}


echo $view->render(['title' => 'Submit FILES', 'Erro' => $errorMsg]);
