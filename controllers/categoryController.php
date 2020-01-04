<?php

class CategoryController extends Controller{

    public $modelName="category";

    public function index(){
        print_r($this->model->getAll()->rowCount());
    }
}