<?php

class Post extends Model {

    public $post_id;
    public $post_title;
    public $post_content;
    public $post_big_image;
    public $post_slug;
    public $post_tags;
    public $post_category;
    public $post_status;
    public $post_createdAt;

    public $tableName="posts";
    private $limit=10;


    public function getCount($slug=""){
        if(!$slug) {
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM " . $this->tableName . " where post_status=1")
                ->fetch(PDO::FETCH_ASSOC);
        }else{
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM " . $this->tableName . " 
                                                where post_status=1 and post_category = 
                                                ( SELECT category_id FROM categories WHERE category_slug = ? )");
            $stmt->bindParam(1,$slug);
            $stmt->execute();
            $stmt=$stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $stmt["total"];
    }

    public function getAll($page=0)
    {
        $offset=$this->limit*$page;
        $stmt=$this->db->prepare("SELECT p.*,c.category_name,c.category_slug FROM ".$this->tableName." p,categories c WHERE p.post_category = c.category_id
                                            ORDER BY post_createdAt DESC LIMIT ".$this->limit." OFFSET ".$offset);
        $stmt->execute();
        return $stmt;
    }

    public function get($id)
    {
        $stmt=$this->db->prepare("SELECT p.*,c.category_name,c.category_slug FROM ".$this->tableName." p,categories c WHERE p.post_category=c.category_id AND post_id=? LIMIT 1");
        $stmt->bindParam(1,$id);
        $stmt->execute();

        return $stmt;
    }

    public function getWithCategorySlug($slug,$page=0){
        $offset=$this->limit*$page;
        $stmt=$this->db->prepare("SELECT p.*,c.category_name,c.category_slug FROM ".$this->tableName." p,categories c 
                                            WHERE p.post_category= c.category_id AND c.category_slug=?
                                            ORDER BY p.post_createdAt DESC LIMIT ".$this->limit." OFFSET ".$offset);
        $stmt->bindParam(1,$slug);
        $stmt->execute();

        return $stmt;
    }

}