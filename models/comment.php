<?php

class Comment extends Model {

    public $tableName="comments";

    public function get($id){
        $stmt=$this->db->prepare("SELECT * FROM ".$this->tableName." WHERE comment_status = 1 AND post_id=?");
        $stmt->bindParam(1,$id);
        $stmt->execute();

        return$stmt;
    }
}