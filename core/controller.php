<?php

class Controller
{
    public $model;

    public function __construct($modelName)
    {
        $this->model($modelName);
    }

    public function model($model)
    {
        $database=new Database();
        require_once MDIR . $model . ".php";
        $this->model = new $model($database->getConnection());
    }
}