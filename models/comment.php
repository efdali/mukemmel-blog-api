<?php

class Comment extends Model {

    public $tableName="comments";

    public function get($id){
        $stmt=$this->db->prepare("SELECT * FROM ".$this->tableName." WHERE comment_status = 1 AND post_id=? ORDER BY comment_createdAt DESC LIMIT 10");
        $stmt->bindParam(1,$id);
        $stmt->execute();

        return $stmt;
    }

    public function add($postId,$user,$comment,$ip){
        $stmt=$this->db->prepare("INSERT INTO ".$this->tableName." SET comment_user= :user,comment_content = :comment,post_id = :postId,comment_user_ip = :ip");
        $stmt->bindParam(":user",$user);
        $stmt->bindParam(":comment",$comment);
        $stmt->bindParam(":postId",$postId);
        $stmt->bindParam(":ip",$ip);
        $insert=$stmt->execute();

        return $insert;
    }
}