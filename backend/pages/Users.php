<?php 

include './database.php';
class Users extends Database{
    public $tableName = "users";
    public $result = array();
    public function selectAllUsers()
    {
        $result = $this->select($this->tableName, "*");
        print_r($result);
    }
    public function selectProduct()
    {
        $result = $this->select("products" , "*");
        print_r($result);
    }
    public function insertForm($data)
    {
        
        $result = $this->insert($data , $this->tableName);
        $db = new Database();
    }
}
