<?php
require_once("./model/Document.php");

$document = new Document();

$users_id = $_SESSION['auth'];

$hasId = null;

isset($req[1]) ? (explode("=", $req[1])[0] == "id" ? $hasId = $req[1] : "") : "";

if ($hasId) {
  $fId = explode("=", $hasId)[1];
}

$document->deleteDocument($fId, $users_id);

header("Location: /view-files");
