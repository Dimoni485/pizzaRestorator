<?php
//include 'models/Db.php';
include 'StorageClass.php';
class GoodsProviderClass extends Db{
    private $storage;
    public function getListPay(){
        $result = $this->setQuery("SELECT DATA_POS, SUM(ITOGO), NUM_SCET, count(PRODUKT) FROM tovar_postavsik GROUP BY DATA_POS, NUM_SCET ORDER BY NUM_SCET DESC LIMIT 30");
        if ($result){
            return $result;
        }
    }
    public function getProductPlay($date, $numpay){
        $result = $this->setQuery("SELECT * FROM `tovar_postavsik` WHERE DATA_POS = '$date' AND NUM_SCET = '$numpay'");
        if ($result){
            return $result;
        }
    }

    public function getMaxNumberScet(){
        $result = $this->setQuery("SELECT max(NUM_SCET) FROM `tovar_postavsik`");
        if ($result){
            return $result;
        }
    }
    public function getSkladProduct(){
        //$result = $this->setQuery("SELECT PRODUKT, CENA FROM `sklad` ORDER BY PRODUKT");
        $result = $this->setQuery("SELECT PRODUKT, max(CENA), POSTAVSIK_NAME FROM `tovar_postavsik` GROUP BY PRODUKT, POSTAVSIK_NAME ORDER BY PRODUKT");
        if ($result){
            return $result;
        }
    }
    public function getProviderName(){
        $result = $this->setQuery("SELECT `NAME` FROM `postavsik` ORDER BY `NAME`");
        if ($result){
            return $result;
        }
    }
    public function addNewCheck($numCheck, $name, $date, $provider, $ediz, $colvo, $cena, $itogo){
        $this->insertQuery('tovar_postavsik'," `PRODUKT`, `POSTAVSIK_NAME`, `KOLVO`, `CENA`, `DATA_POS`, `NUM_SCET`, `ITOGO`, `ED_IZ`, `KOLVO_BRUTTO`, `CENA_BRUTTO`","'$name','$provider','$colvo','$cena','$date','$numCheck','$itogo','$ediz','$colvo','$cena'");
        $update = $this->updateQuery("`sklad`","KOLVO=KOLVO+$colvo, CENA='$cena'","PRODUKT","'$name'");
        if ($update==0){
            $this->insertQuery("`sklad`","`PRODUKT`, `KOLVO`, `SUMMA`, `ED_IZ`, `CENA`","'$name','$colvo','$itogo','$ediz','$cena'");
        }
        
    }
    public function deleteCheck($numCheck){
        $result = $this->deleteQuery("`tovar_postavsik`","NUM_SCET",$numCheck);
    }
    public function deleteRowsCheck($id){
        $this->storage = new StorageClass;
        $prod = $this->setQuery("SELECT PRODUKT, KOLVO FROM `tovar_postavsik` WHERE ID='$id'");
        $product = $prod[0][0];
        $kolvo = $prod[0][1];
        $this->updateQuery("`sklad`","KOLVO=KOLVO-$kolvo","PRODUKT","'$product'");
        $this->storage->updatePriceStorage();
        $result = $this->deleteQuery("`tovar_postavsik`","ID", $id);
        if($result){
            return $result;
        }
    }
}