<?php 

require_once("BaseModel.php");
class TransModel extends BaseModel{

    /**
     * function digunakan untuk mengambil mengambil data
     * 
     * contoh pengisian $fields :
     * 
     * $fields = ['id', 'nama'] : berarti menampilkan dengan kriteria field, seperti : "SELECT id, nama FROM".
     * $fields = [] : berarti menampilkan semua field, seperti : "SELECT * FROM".
     */
    public function select($tableName = "", $fields = [], $where = "") : array {
        // include '../config.php';
        $conn   = $this->loadConnection();
        $sql    = $this->buildSelectQuery($tableName, $fields, $where);
        $data   = $conn->query($sql);
        if (!$data)
            throw new Exception("[TransModel] " .$tableName. ", " . $conn->error, 1);
        $conn->close();
        return $this->arrayQueryMaping($data);
    }

    /**
     * function untuk store data;
     */
    public function store($tableName = "", $arrData = [], $who = "") : void {
        $conn   = $this->loadConnection();
        $sql    = $this->buildInsertQuery($tableName, $arrData, $who);
        $data   = $conn->query($sql);
        if (!$data)
            throw new Exception("[TransModel] " .$tableName. ", " . $conn->error, 1); 
        $conn->close();
    }

      /**
     * function untuk update data;
     */
    public function update($tableName = "", $arrData = [], $arrWhere = [], $who = "") : void {
        $conn   = $this->loadConnection();
        $sql    = $this->buildUpdateQuery($tableName, $arrData, $arrWhere, $who);
        $data   = $conn->query($sql);
        if (!$data)
            throw new Exception("[TransModel] " .$tableName. ", " . $conn->error, 1);
        $conn->close();
    }

    /**
     * Get the value of config
     */ 
    public function getConfig()
    {
        return $this->config;
    }
}
?>