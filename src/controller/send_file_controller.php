<?php

require("../model/User.php");

require("../model/Document.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo memory_get_usage();

  $email = $_POST['email'];

  $targetDir = "../docs/";
  $allowedExtensions = ['pdf'];
  echo memory_get_usage();

  if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
    $file = $_FILES['arquivo'];
    $fileName = basename($file['name']);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $randomData = date('YmdHis') . rand(1000, 9999);
    $targetPath = $targetDir . $randomData . $fileName;
    $document = new Document();
    $user = new User();
    $dataUser = $user->getUserByEmail($email);
    if (!$dataUser) {
      echo "Erro";
      return;
    }

    $document->create([
      "users_id" => $dataUser['id'],
      "path" => $targetPath,
      "description" => $fileName
    ]);

    if (in_array($fileExtension, $allowedExtensions)) {

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