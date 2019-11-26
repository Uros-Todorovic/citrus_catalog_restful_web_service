<?php

class Database {
    private static $instance = null;
    private $connection;
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $db_name = "citrus_catalog";

    private function __construct(){
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->db_name}",$this->user,$this->password);
        //$this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function get_connection(){
        if (!self::$instance) {
            self::$instance = new Database; 
        }
        return self::$instance;
    }

    public function connect(){
        return $this->connection;
    }

    public function get_row($query,$params){
        $data = $this->connection->prepare($query);
        $data->execute($params);
        $result = $data->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function get_rows($sql){
       $result = [];
       $data = $this->connection->query($sql);
       while ($row = $data->fetch(PDO::FETCH_OBJ)) {
           $result[] = $row;
       } 
       return $result;
    }

    public function insert_row($query, $params){
        $data = $this->connection->prepare($query);
        $inserted = $data->execute($params);
        return $inserted;
    }
    
    public function update_row($sql, $params){
        $data = $this->connection->prepare($sql);
        $data->execute($params);
        $rows_affected = $data->rowCount();
        return ($rows_affected == 1) ? true : false;
    }
    
    public function delete_row($sql, $params){
        $data = $this->connection->prepare($sql);
        $data->execute($params);
        $rows_affected = $data->rowCount();
        return ($rows_affected == 1) ? true : false;
    }

}