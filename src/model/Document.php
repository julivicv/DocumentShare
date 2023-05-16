<?php
require_once("Model.php");
session_start();
class Document extends Model
{
    public function searchDocuments($users_id, $search)
    {
        try {
            $query = "SELECT d.id, d.users_id, d.path, d.name, p.can_view, p.can_edit, p.can_delete, d.created_at
            FROM documents AS d
            LEFT JOIN users AS u ON d.users_id = u.id
            JOIN document_permissions AS p ON p.documents_id = d.id
            WHERE (d.users_id = ? OR u.id = ?)
            AND (d.name LIKE ? OR d.path LIKE ? OR d.created_at LIKE ?)";

            $statement = $this->conex->prepare($query);
            $searchTerm = '%' . $search . '%';
            $statement->execute([$users_id, $users_id, $searchTerm, $searchTerm, $searchTerm]);


            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    public function getDocument($id, $users_id)
    {
        $query = "SELECT * FROM documents WHERE id = ? AND users_id = ?";
        $statement = $this->conex->prepare($query);
        $statement->execute([$id, $users_id]);
        $document = $statement->fetch(PDO::FETCH_ASSOC);
        return $document;
    }
    public function getDocumentsByUserId($users_id)
    {
        try {
            $query = "SELECT * FROM documents as d JOIN document_permissions as p ON p.documents_id = d.id  WHERE d.users_id = ?";
            $statement = $this->conex->prepare($query);
            $statement->execute([$users_id]);
            $documents = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $documents;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function deleteDocument($id, $users_id)
    {
        try {
            $query = "SELECT * FROM documents as d JOIN document_permissions as p ON p.documents_id = d.id WHERE d.id = ? and d.users_id = ? and p.can_delete = 1";
            $statement = $this->conex->prepare($query);
            $statement->execute([$id, $users_id]);
            $document = $statement->fetch(PDO::FETCH_ASSOC);

            if (!isset($document)) {
                return false; // Document not found or user does not have permission
            }

            $deleteQuery = "DELETE FROM documents WHERE id = ?";

            $deleteStatement = $this->conex->prepare($deleteQuery);
            $deleteStatement->execute([$id]);

            if ($deleteStatement->rowCount() > 0) {
                $filePath = $document['path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }


                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e;
            die;


            return false;
        }
    }

    public function createDocument($users_id, $path, $name, $permitions)
    {

        try {
            $this->conex->beginTransaction();

            // Inserir o documento na tabela "documents"
            $query = "INSERT INTO documents (users_id, path, name) VALUES (?, ?, ?)";
            $statement = $this->conex->prepare($query);
            $statement->execute([$users_id, $path, $name]);
            $documentId = $this->conex->lastInsertId();
            $permitionsRead = $permitions[0];
            $permitionsWrite = $permitions[1];
            $permitionsDelete = $permitions[2];


            // Definir as permissões padrão para o usuário que criou o documento
            $query = "INSERT INTO document_permissions (documents_id, users_id, can_view, can_edit, can_delete) VALUES (?, ?, $permitionsRead, $permitionsWrite, $permitionsDelete)";
            $statement = $this->conex->prepare($query);
            $statement->execute([$documentId, $users_id]);

            $this->conex->commit();

            return $documentId;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
            $this->conex->rollBack();
            return false;
        }
    }
    public function updateDocument($id, $users_id, $path, $name)
    {
        try {
            $query = "UPDATE documents SET path = ?, name = ? WHERE id = ? AND users_id = ?";
            $statement = $this->conex->prepare($query);
            $statement->execute([$path, $name, $id, $users_id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
