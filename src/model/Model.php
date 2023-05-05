<?php
class Model
{

    // Não é a forma mais indicada de armazenar usuário e senha
    private $driver = 'mysql';
    private $host = 'localhost';
    private $dbname = 'docShare';
    private $port = '3306';
    private $user = 'root';
    private $password = null;
    protected $table;
    protected $conex;

    public function __construct()
    {
        $tbl = strtolower(get_class($this));
        $tbl .= 's';
        $this->table = $tbl;
        $this->conex = new PDO("{$this->driver}:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->password);
    }

    public function create($data)
    {
        $query = "INSERT INTO {$this->table} SET ";
        $sql_fields = $this->map_fields($data);
        $finalQuery = $query . implode(', ', $sql_fields);
        $sql = $this->conex->prepare($finalQuery);
        foreach ($data as $key => $value) {
            $sql->bindParam(":$key", $data[$key]);
        }
        $sql->execute();
    }

    private function map_fields($data)
    {
        foreach (array_keys($data) as $field) {
            $sql_fields[] = "{$field} = :{$field}";
        }
        return $sql_fields;
    }
}