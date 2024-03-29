<?php
    class DBConnection{
        function __construct(){
            require_once(__DIR__.'/database.php');
            $this->db_params = $db_params;
        }

        function getConnection(){
            $conn = new mysqli($this->db_params["servername"],$this->db_params["username"],$this->db_params["password"],$this->db_params["dbname"]);
            if($conn->connect_error){
                die("Connection Failed: ". $conn->connect_error);
            }
            return $conn;
        }
    }
?>