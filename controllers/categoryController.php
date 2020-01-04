<?php

class CategoryController extends Controller{

    public $modelName="category";

    public function index(){
        $stmt=$this->model->getAll();
        $count=$stmt->rowCount();

        if($count>0){
            $result=array();
            foreach ($stmt as $row){
                $category=array(
                    "category_id"=>$row["category_id"],
                    "name"=>$row["category_name"],
                    "description"=>$row["category_description"],
                    "slug"=>$row["category_slug"]
                );
                array_push($result,$category);
            }
            http_response_code(200);
            echo json_encode(array(
                "status"=>1,
                "result"=>$result,
                "count"=>$count
            ));
        }else{
            http_response_code(404);
            echo json_encode(array("status"=>0,"message"=>"Mevcut Kategori Yok"));
        }
    }
}