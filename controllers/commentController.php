<?php

class CommentController extends Controller{

    public $modelName="comment";

    public function index(){

    }

    public function add(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        $user=$_POST["user"];
        $comment=$_POST["comment"];
        $postId=$_POST["postId"];

        if($user && $comment && $postId){

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $insert=$this->model->add($postId,$user,$comment,$ip);
            if($insert){
                http_response_code(200);
                echo json_encode(array("status"=>1,"message"=>"Yorum Başarıyla Eklendi"));
            }
        }else{
            http_response_code(500);
            echo json_encode(array("status"=>0,"message"=>"Bir Sorun Oluştu"));
        }
    }
}