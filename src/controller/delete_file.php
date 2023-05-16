<?php
require_once("../model/Document.php");

$document = new Document();

$id = $_GET['id'];
$users_id = $_SESSION['id'];

$document->deleteDocument($id, $users_id);


header("Location: ./view_file_page.php");
