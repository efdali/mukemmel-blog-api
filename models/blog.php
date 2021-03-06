<?php

class Blog extends Model {

    public $post_id;
    public $post_title;
    public $post_content;
    public $post_big_image;
    public $post_slug;
    public $post_tags;
    public $post_category;
    public $post_status;
    public $post_createdAt;

    public $tableName="blogs";
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

    public function getPopulars(){
        $stmt=$this->db->prepare("SELECT p.post_id,p.post_title,p.post_big_image,p.post_slug,p.post_createdAt,c.category_name,c.category_slug FROM ".$this->tableName
            ." p,categories c,comments co WHERE p.post_category=c.category_id AND p.post_id = co.post_id AND post_status=1 
            GROUP BY p.post_id ORDER BY COUNT(co.comment_id) DESC LIMIT 5");
        $stmt->execute();

        return $stmt;
    }

    public function get($id)
    {
        $stmt=$this->db->prepare("SELECT p.*,c.category_name,c.category_slug FROM ".$this->tableName." p,categories c WHERE p.post_category=c.category_id AND post_slug=? LIMIT 1");
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

    public function getRandom($id){
        $id+=1;
        $stmt=$this->db->prepare("SELECT post_title,post_slug FROM ".$this->tableName." p WHERE post_status=1 and post_id=? LIMIT 1");
        $stmt->bindParam(1,$id);
        $stmt->execute();

        return $stmt;
    }

    public function search($s,$page=0){
        $s="%".$s."%";
        $offset=$this->limit*$page;
        $stmt=$this->db->prepare("SELECT p.*,c.category_name,c.category_slug FROM ".$this->tableName." p,categories c 
                                        WHERE p.post_category=c.category_id AND  post_status=1 AND post_title LIKE :s1 OR post_tags LIKE :s2 
                                         ORDER BY p.post_createdAt DESC LIMIT ".$this->limit." OFFSET ".$offset);
        $stmt->bindParam(":s1",$s);
        $stmt->bindParam(":s2",$s);
        $stmt->execute();

        return $stmt;
    }

    public function searchCount($s){
        $s="%".$s."%";
        $stmt=$this->db->prepare("SELECT COUNT(p.post_id) as total FROM ".$this->tableName." p
                                        WHERE post_status=1 AND post_title LIKE :s1 OR post_tags LIKE :s2");
        $stmt->bindParam(":s1",$s);
        $stmt->bindParam(":s2",$s);
        $stmt->execute();
        $stmt=$stmt->fetch(PDO::FETCH_ASSOC);

        return $stmt["total"];
    }

}