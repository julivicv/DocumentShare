<?php
require('./utils/load_twig.php');
require('./utils/erros.php');
session_start();

$view = $twig->load('search_file.html');

if (!isset($_SESSION['auth'])) {
  header("Location: /register");
}

echo $view->render(['title' => 'Search Files']);
