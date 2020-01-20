<?php


class database
{
    public $db;
    private $host="localhost";
    private $dbname="kuzenbil_nosbir";
    private $username="kuzenbil_nosbird";
    private $passwd="*#3156/*EE";

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