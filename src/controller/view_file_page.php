<?php

require('./utils/load_twig.php');
require('./utils/erros.php');
require('./model/Document.php');

$view = $twig->load('view_file.html');

if (!isset($_SESSION['auth'])) {
  header("Location: /login");
    exit;
}

$docs = new Document();
$userId = $_SESSION["auth"];

$documents = $docs->getDocumentsByUserId($userId);

$search = isset($_POST['search']) ? $documents = $docs->searchDocuments($userId, $_POST['search']) : null;

if (!isset($documents[0])) {
    $documents = "Nenhum arquivo encontrado";
}


echo $view->render(['title' => 'List FILES', 'files' => $documents]);
