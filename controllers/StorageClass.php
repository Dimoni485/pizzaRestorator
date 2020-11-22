<?php
include "models/Db.php";
class StorageClass extends Db{
    public function getStorageListProduct(){
        $result = $this->setQuery("SELECT * FROM sklad ORDER BY PRODUKT");
        if ($result){
            return $result;
        }
    }
    public function checkDeleteButton($productName){
        $result = $this->setQuery("SELECT ID_PRODUKCIYA FROM `sostav` WHERE PRODUKT = '$productName' AND ID_PRODUKCIYA!='' ORDER BY ID");
        if ($result){
            return $result;
        }else{
            return 0;
        }
    }
    public function updateColvoStorage($id, $newcolvo){
        $this->updateQuery("`sklad`","KOLVO='$newcolvo'","ID",$id);
    }

    public function deleteStorageProduct($id){
        $this->deleteQuery("`sklad`","ID", $id);
    }
    public function updatePriceStorage(){
        $this->queryQuery("UPDATE `sklad` SET SUMMA=(CENA * KOLVO) WHERE CENA > 0");
    }
}
