<?php 

require_once("Config.php");
class BaseModel extends Config{

    protected function loadConnection(){
        return $this->getConnection();
    }

    protected function buildSelectQuery($tableName = "", $arrSelect = [], $whereStatement = "") : string {

        if ($tableName == "")
            throw new Exception("Tolong isikan nama table",1);

        $fieldSelect = "SELECT * ";
        if (count($arrSelect) > 0) {
            $fieldSelect = "SELECT  ";
            foreach ($arrSelect as $i => $p) {
                if (($i+1) == count($arrSelect))
                    $fieldSelect .= " ".$p;
                else 
                    $fieldSelect .= " ".$p.",";
            }
        }

        $fieldSelect .= " FROM ".$tableName;        
        return $fieldSelect." ".$whereStatement;
    }

    private function isOperator($opt) : bool {
        $opt        = strtolower($opt);
        $isEquals   = strpos("=", $opt);
        $isLike     = strpos("like", $opt);
        return $isEquals && $isLike;
    }

    protected function buildInsertQuery($tableName, $data = array(), $who) : string {
        
        $today  = $this->getTodayDateTime();
    
        if ($tableName == null || $tableName == "")
            throw new Exception("Table Name Not Found", 1);
    
        if ($data == null || count($data) == 0)
            throw new Exception("Data Column And Values Not Found", 1);
    
        $column = "";
        $values = "";
    
        foreach ($data as $i => $p) {
            $column .= "".$i. ",";
            $values .= "'".$p. "',";
        }
    
        $sql = "INSERT INTO " . $tableName . "(" . $column . " created_at, created_who" . ")"
                . " VALUES (" . $values . " '".$today."', '".$who."')";  
        
        return $sql;
    }
    
    protected function buildUpdateQuery($tableName, $data = array(), $idData = array(), $who) : string {
        
        $today  = $this->getTodayDateTime();
    
        if ($idData == null || count($idData) == 0)
            throw new Exception("id Not Found", 1);
    
        if ($tableName == null || $tableName == "")
            throw new Exception("Table Name Not Found", 1);
    
        if ($data == null || count($data) == 0)
            throw new Exception("Data Column And Values Not Found", 1);
    
        $setBuilder = "";
        $n1 = 1;
        foreach ($data as $i => $p) {
            if ($n1 == 1){
                $setBuilder .= $i . " = " . "'".$p."'";
            } else {
                $setBuilder .= ", " . $i . " = " . "'".$p."'";
            }
            $n1 ++;
        }
        $setBuilder .= ", updated_at = '".$today."', updated_who = '".$who."' ";
    
        $whereBuilder = " WHERE ";
        $n2 = 1;
        foreach ($idData as $i => $p) {
            if ($n2 == 1){
                $whereBuilder .= $i . " = " . "'".$p."'";
            } else {
                $whereBuilder .= " AND " . $i . " = " . "'".$p."'";
            }
            $n2 ++;
        }
    
        $sql = "UPDATE " . $tableName . " SET " . $setBuilder . $whereBuilder;  
        return $sql;
    }

    protected function arrayQueryMaping($fetchQueryData = []) : array {
        $res = [];
        foreach ($fetchQueryData as $i => $p) {
            $res[$i] = $p;
        }
        return $res;
    }
    
    private function getTodayDate(){
        date_default_timezone_set("Asia/Jakarta");
        return date('Y-m-d');
    }
    
    private function getTodayDateTime(){
        date_default_timezone_set("Asia/Jakarta");
        return date('Y-m-d H:i:s');
    }
}

?>