<?php

Class User extends Model {

    public function getUserById($id){
        $sql = $this->conex->prepare("SELECT * FROM {$this->table} WHERE `id` = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function login($mail, $pass){
        $sql = $this->conex->prepare("SELECT * FROM {$this->table} WHERE `email` = :mail");
        $sql->bindParam(":mail", $mail);
        $sql->execute();

        if($sql->rowCount()) {
            $user = $sql->fetch(PDO::FETCH_OBJ);
            if(password_verify($pass, $user->pass)) {
                session_start();
                $_SESSION['user'] = $user->nome;
                header("Location: ");
            }


        }
    }
}