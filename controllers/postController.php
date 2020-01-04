<?php

class PostController extends Controller{

    public $modelName="post";

    public function index(){
        $args=func_get_args();
        $argsCount=count($args);
        $slug=null;
        if($argsCount == 2){
            $slug= $args[0];
            $page=$args[1];
        }else if($argsCount ==1){
            $page=$args[0];
        }else{
            $page=0;
        }

        if($slug){
            $stmt=$this->model->getWithCategorySlug($slug,$page);
            $count=$this->model->getCount($slug);
        }else{
            $stmt=$this->model->getAll($page);
            $count=$this->model->getCount();
        }
        $num=$stmt->rowCount();
        $result=array();
        if($num>0) {
            foreach ($stmt as $row) {
                $post=array(
                    "post_id"=>$row["post_id"],
                    "title"=>$row["post_title"],
                    "content"=>$row["post_content"],
                    "big_image"=>$row["post_big_image"],
                    "post_slug"=>$row["post_slug"],
                    "tags"=>$row["post_tags"],
                    "category"=>$row["category_name"],
                    "category_slug"=>$row["category_slug"],
                    "createdAt"=>$row["post_createdAt"]
                );
                array_push($result, $post);
            }
            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "result" => $result,
                "count" => $count
            ));
        }else{
            http_response_code(404);
            echo json_encode(array("status"=>0,"message"=>"Post Bulunamadı"));
        }
    }

    public function get($id=0){
        if($id>0){
            $stmt=$this->model->get($id);
            if($stmt->rowCount() > 0){

                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                $post=array(
                    "post_id"=>$row["post_id"],
                    "title"=>$row["post_title"],
                    "content"=>$row["post_content"],
                    "big_image"=>$row["post_big_image"],
                    "post_slug"=>$row["post_slug"],
                    "tags"=>$row["post_tags"],
                    "category"=>$row["category_name"],
                    "category_slug"=>$row["category_slug"],
                    "createdAt"=>$row["post_createdAt"]
                );
                http_response_code(200);
                echo json_encode(array("status"=>1,"result"=>$post));
            }else{
                http_response_code(404);
                echo json_encode(array("status"=>0,"message"=>"Post Bulunamadı"));
            }
        }else{
            http_response_code(500);
           echo json_encode(array("status"=>0,"message"=>"Bir Sorun Oluştu"));
        }
    }

}