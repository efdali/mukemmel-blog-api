<?php


class Model
{

    public $db;
    public $tableName;

    public function __construct()
    {
        $database=new Database();
        $this->db=$database->getConnection();
    }

}