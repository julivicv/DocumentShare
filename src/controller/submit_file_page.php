<?php
require('../utils/load_twig.php');
require('../utils/erros.php');
session_start();

$view = $twig->load('submit_files.html');

if (!isset($_SESSION['auth'])) {
  header("Location: create_user_controller.php");
}
$errorValue = (int) isset($_GET["error"]) ? $_GET["error"] : 0;

if ($errorValue > 0) {

  $errorMsg = $error[$_GET["error"]];
}

if (!isset($errorMsg)) {
  $errorMsg = "";
}


echo $view->render(['title' => 'Submit FILES', 'error' => $errorMsg]);
