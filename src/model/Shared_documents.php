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

        if ($sql->rowCount() > 0) {
            $userShare = $this->conex->prepare("SELECT `id` FROM `users` `u``u`.`email` = :email");
            $userShare->bindParam(':email', $email);
            $userId = $userShare->execute();
            $sql = $this->conex->prepare("INSERT INTO {$this->table} (users_id, document_id) VALUES (:uid, :fid)");
            $sql->bindParam(':uid', $userId['id']);
            $sql->bindParam(':fid', $fid);
            $sql->execute();
            return ("Documento compartilhado com sucesso!");
        }
    }
}