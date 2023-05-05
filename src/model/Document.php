<?php

class Document extends Model {
    public function getDocumentById($id, $auth)
    {
        $sql = $this->conex->prepare("SELECT `d`.`path`, `d`.`description` FROM `documents` `d` LEFT JOIN `shared_documents` `sd` ON `d`.`id` = `sd`.`documents_id` WHERE `d`.`id` = :id AND (`d`.`users_id` = :uid OR `ds`.`users_id` = :uid)");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':uid', $auth);
        $sql->execute();
        if($sql->rowCount()) {
            return $sql->fetch(PDO::FETCH_ASSOC);
            die;
        }
        return ("Arquivo inválido ou não encontrado");
    }

    public function createDocument($data, $file) {
        if(isset($file)) {
            if ($file['upfile']['size'] > 1000000) {
                return('Arquivo muito grande');
                die;
            }
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                    $finfo->file($_FILES['upfile']['tmp_name']),
                    array(
                        'pdf' => 'document/pdf',
                        'doc' => 'document/doc',
                        'docx' => 'document/docx',
                    ),
                    true
                )) {
                return('Arquivo inválido');
            }
            if (!move_uploaded_file(
                $_FILES['upfile']['tmp_name'],
                sprintf('../documents/%s.%s',
                    sha1_file($_FILES['upfile']['tmp_name']),
                    $ext
                )
            )) {
                return('Falha no upload');
            }
            parent::create($data);
            return('Arquivo salvo com sucesso');
        }
    }
}