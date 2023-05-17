<?php
require_once("./model/Document.php");

$document = new Document();


$id = $_GET['id'];
$users_id = $_SESSION['auth'];

$document->deleteDocument($id, $users_id);


header("Location: /view-files");
