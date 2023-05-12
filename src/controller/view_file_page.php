<?php
require('../utils/load_twig.php');
require('../utils/erros.php');
require('../model/Document.php');

session_start();

$view = $twig->load('view_file.html');

if (!isset($_SESSION['auth'])) {
    header("Location: create_user_controller.php");
    exit;
}

$docs = new Document();
$userId = $_SESSION["auth"];

$listDocs = $docs->getDocumentByUser($userId);
echo $view->render(['title' => 'List FILES', 'files' => $listDocs]);