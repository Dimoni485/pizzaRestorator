<?php
include 'models/Db.php';
class KatClass extends Db{
    public function getKat(){
        $result = $this->setQuery("SELECT kategorii.ID, kategorii.KAT, (SELECT COUNT(produkciya.PRODUKT) FROM produkciya WHERE produkciya.KATEGORIYA=kategorii.KAT) FROM kategorii ORDER BY KAT");
        if ($result){
            return $result;
        }
    }
    public function addKat($katname){
        $result= $this->insertQuery("`kategorii`","KAT","'$katname'");
        if ($result){
            return $result;
        }
    }
    public function deleteKat($id){
        $result=$this->deleteQuery("`kategorii`","ID",$id);
    }
}