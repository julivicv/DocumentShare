<?php
require("Model.php");
class User extends Model
{
    public function getUserByEmail($email)
    {
        $sql = $this->conex->prepare("SELECT * FROM {$this->table} WHERE `email` = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }
    public function getUserById($id)
    {
        $sql = $this->conex->prepare("SELECT * FROM {$this->table} WHERE `id` = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function login($mail, $pass)
    {
        $sql = $this->conex->prepare("SELECT * FROM {$this->table} WHERE `email` = :mail");
        $sql->bindParam(":mail", $mail);
        $sql->execute();

        if ($sql->rowCount()) {
            $user = $sql->fetch(PDO::FETCH_OBJ);
            if (password_verify($pass, $user->password)) {
                session_start();
                $_SESSION['auth'] = $user->id;
                header("Location: home_page.php ");
            } else {
                header("Location: login_user_page.php ");
            }
        }
    }
}