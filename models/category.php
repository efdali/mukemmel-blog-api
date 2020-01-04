<?php

class Category extends Model {

    public $tableName="categories";

    public function get($id){
        $stmt=$this->db->prepare("SELECT * FROM ".$this->tableName." WHERE category_id=?");
        $stmt->execute(array(strip_tags($id)));

        return$stmt;
    }

    public function getAll()
    {
        $stmt=$this->db->prepare("SELECT * FROM ".$this->tableName." WHERE category_status=1 ORDER BY category_order");
        $stmt->execute();

        return $stmt;
    }

}