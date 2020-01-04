<?php


class Model implements IModel
{

    public $db;
    public $tableName;

    public function __construct()
    {
        $database=new Database();
        $this->db=$database->getConnection();
    }

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function getAll()
    {
        $stmt=$this->db->prepare("select * from ".$this->tableName);
        $stmt->execute();
        return $stmt;
    }
}