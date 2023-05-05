<?php
require('../utils/load_twig.php');
require('../utils/erros.php');
session_start();

$view = $twig->load('home.html');

if (!isset($_SESSION['auth'])) {
    header("Location: create_user_controller.php");
}

echo $view->render(['title' => 'Home']);