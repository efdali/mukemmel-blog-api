<?php


class database
{
    public $db;
    private $host="localhost";
    private $dbname="mukemmel-blog";
    private $username="root";
    private $passwd="";

    public function getConnection(){
        if($this->db != null){
            return $this->db;
        }

        try{
            $this->db=new PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8",$this->username,$this->passwd);
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $this->db;
    }

}