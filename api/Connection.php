<?php

    class Connection
    {
        var $host = "localhost";
        var $username = "root";
        var $password = "";
        var $db_name = "db_cutilembur";
        var $con;

        public function dbConnection()
        {
            try {
                $this->con = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $this->con;
            } catch (PDOException $e) {
                $e->getMessage();
            }
        }
    }
    

?>