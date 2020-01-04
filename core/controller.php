<?php

class Controller
{
    public $model;
    public $modelName;

    public function __construct()
    {
        $this->model($this->modelName);
    }

    public function model($model)
    {
        $database=new Database();
        require_once MDIR . $model . ".php";
        $this->model = new $model($database->getConnection());
    }
}