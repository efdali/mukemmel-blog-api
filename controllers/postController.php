<?php

class PostController extends Controller{

    public $modelName="post";

    public function index(){
        print_r($this->model->getAll()->rowCount());
    }
}