<?php

require("../model/User.php");
require("../model/Document.php");
require("../model/Shared_documents.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $email = $_POST['email'];

  $targetDir = "../docs/";
  $allowedExtensions = ['pdf'];

  if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
    $file = $_FILES['arquivo'];
    $fileName = basename($file['name']);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $randomData  = date('YmdHis') . rand(1000, 9999);
    $targetPath = $targetDir . $randomData . $fileName;

    $document = new Document();
    $user = new User();

    $dataUser = $user->getUserByEmail($email);

    $document->create([
      "users_id" => $dataUser['id'],
      "path" => $targetPath,
      "description" => $fileName
    ]);
    $documentShared = new Shared_documents();
    $documentShared->create([
      "users_id" => $dataUser['id'],
      "document_id" => $document
    ]);
    // Verifica se a extensão do arquivo é permitida
    if (in_array($fileExtension, $allowedExtensions)) {

      // Move o arquivo para a pasta de destino
      if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo "O arquivo foi enviado com sucesso e salvo em: " . $targetPath;
      } else {
        echo "Ocorreu um erro ao salvar o arquivo.";
      }
    } else {
      echo "A extensão do arquivo não é permitida. Por favor, envie um arquivo com uma das seguintes extensões: " . implode(', ', $allowedExtensions);
    }
  } else {
    echo "Nenhum arquivo foi enviado.";
  }
}
