<?php
session_start();
class Shared_documents extends Model
{
    public function shareDocument($uid, $email, $fid)
    {
        $sql = $this->conex->prepare("SELECT * FROM `users` `u` LEFT JOIN `documents` `d` WHERE `u`.`id` = :uid AND `d`.`id` = :fid");
        $sql->bindParam(':uid', $uid);
        $sql->bindParam(':fid', $fid);
        $sql->execute();

        if($sql->rowCount() > 0) {
                $userShare = $this->conex->prepare("SELECT `id` FROM `users` `u``u`.`email` = :email");
                $userShare->bindParam(':email', $email);
                $userShare->execute();
                $userId = $userShare->fetch(PDO::FETCH_ASSOC);
                $sql = $this->conex->prepare("INSERT INTO {$this->table} (users_id, document_id) VALUES (:uid, :fid)");
                $sql->bindParam(':uid', $userId['id']);
                $sql->bindParam(':fid', $fid);
                $sql->execute();
                return ("Documento compartilhado com sucesso!");
        }
    }

    public function verifySharedDocument($uid, $fid) {
        $sql = $this->conex->prepare("SELECT * FROM `documents` `d` LEFT JOIN `users` `u` on `u`.`id` = `d`.`users_id` LEFT JOIN `shared_documents` `sd` on `d`.`id` = `sd`.`document_id` WHERE `u`.`id` NOT NULL");
        $sql->bindParam(':uid', $uid);
        $sql->bindParam(':fid', $fid);
        $sql->execute();
        if($sql->rowCount() < 0) {
            return false;
        }
        else {
            return true;
        }

    }
}
