<?php
include 'models/Db.php';
class ProviderClass extends Db{
    public function getProvider(){
        $result = $this->setQuery("SELECT postavsik.ID, postavsik.NAME, postavsik.CONTAKT FROM postavsik ORDER BY NAME");
        if ($result){
            return $result;
        }
    }
    public function addProvider($providername){
        $result= $this->insertQuery("`postavsik`","NAME","'$providername'");
        if ($result){
            return $result;
        }
    }
    public function deleteProvider($id){
        $result=$this->deleteQuery("`postavsik`","ID",$id);
    }
}