<?php

class PostController extends Controller{

    public function __construct()
    {
        parent::__construct("post");
    }

    public function index(){
        print_r($this->model->getAll()->rowCount());
    }
}