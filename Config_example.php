<?php

class Config {
    /**
     * get connection configure your database connection here
     */
    protected function getConnection(){
        $servername = "";
        $username   = "";
        $password   = "";
        $database   = "";
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }
}


?>
