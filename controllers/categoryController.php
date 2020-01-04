<?php

class CategoryController extends Controller{

    public function __construct()
    {
        parent::__construct("category");
    }

    public function index(){
        print_r($this->model->getAll()->rowCount());
    }
}