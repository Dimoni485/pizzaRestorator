<?php
class Db{
    public $link;
    private $host = 'localhost';
    private $port = '3422';
    private $user = 'root';
    private $password = 'Vtnfkkbcn2554~';
    private $charset = 'utf8';
    private $datebase = 'pizzeria';
    public $resultArray= array();
    
    function __construct(){
        $this->link = mysqli_connect($this->host, $this->user, $this->password, $this->datebase);
        mysqli_set_charset($this->link, $this->charset);
    }

    public function setQuery($query){
        unset ($this->resultArray);
        $this->resultArray=array();
        $queryarray = mysqli_query($this->link,$query);
        while($result = mysqli_fetch_array($queryarray)){
            array_push($this->resultArray, $result);
        }
        return $this->resultArray;
    }
    public function deleteQuery($tablename, $column, $id){
        $delquery = mysqli_query($this->link, "DELETE FROM $tablename WHERE $column = $id");
        if ($delquery){
            return $delquery;
        }
    }
    public function updateQuery($table, $columndata, $idcolumn ,$id){
        $update = mysqli_query($this->link, "UPDATE $table SET $columndata WHERE $idcolumn=$id");
        if ($update){
            return mysqli_affected_rows($this->link);
        }
    }

    public function insertQuery($table, $columnArray, $valueArray){
        $insert = mysqli_query($this->link, "INSERT INTO $table($columnArray) VALUES($valueArray)");
        if ($insert){
            return $insert;
        }
    }
    public function queryQuery($query){
        $que = mysqli_query($this->link,"$query");
        if (isset($que)){
            return $que;
        }
    }
}