<?php
require("./model/User.php");
require("./model/Document.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = isset($_POST['email']) ? $_POST['email'] : null;
  $delete = isset($_POST['delete']) ? 1 : 0;

  $user = new User();
  $dataUser = $user->getUserByEmail($email);
  if ($dataUser < 0) {
    header("Location: /submit-file?erro=10");
    exit;
  }

  if (empty($_FILES['arquivo']['name'])) {
    header("Location: /submit-file?erro=9");
    exit;
  };

  $targetDir = "./docs/";
  $allowedExtensions = ['pdf'];

  if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
    $file = $_FILES['arquivo'];
    $fileName = basename($file['name']);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $randomData = date('YmdHis') . rand(1000, 9999);
    $targetPath = $targetDir . $randomData . $fileName;

    $document = new Document();
    $dataUser = $user->getUserByEmail($email);


    $permissions = [1, $delete];

    $documentId = $document->createDocument($dataUser['id'], $targetPath, $fileName, $permissions);

    if ($documentId) {
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
      echo "Ocorreu um erro ao criar o documento.";
    }
  } else {
    echo "Nenhum arquivo foi enviado.";
  }
  header("Location: /view-files");
}
