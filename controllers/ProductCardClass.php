<?php
include "models/Db.php";
class ProductCardClass extends Db{
    public function getProductIfId($id){
        $result = $this->setQuery("SELECT * FROM produkciya WHERE ID = $id");
        if ($result){
            return $result;
        }
    }
    public function getSostavProducta($id_product){
        $result = $this->setQuery("SELECT * FROM sostav WHERE ID_PRODUKCIYA='$id_product' ORDER BY PRODUKT");
        if ($result){
            return $result;
        }
    }
    public function getSkladList(){
        $result = $this->setQuery("SELECT PRODUKT, CENA FROM `sklad` ORDER BY PRODUKT");
        if ($result){
            return $result;
        }
    }
    public function insertSostavProduct($nameProduct, $name, $cena, $colvo){
        $cena = $cena+0;
        $colvo = $colvo+0;
        $itogo = $cena*$colvo;
        $this->insertQuery("`sostav`", "`PRODUKT`, `KOLVO`, `ID_PRODUKCIYA`,`ED_IZ`, `SUMMA`, `CENA`", "'$name', '$colvo', '$nameProduct',(SELECT ED_IZ FROM `sklad` WHERE PRODUKT='$name'), '$itogo', '$cena'");
        $this->RascetCenToProduct($nameProduct);
    }
    public function RascetCenToProduct($nameProduct){
        $this->queryQuery("UPDATE sostav AS sos SET CENA=(SELECT CENA FROM sklad AS pr WHERE pr.PRODUKT=sos.PRODUKT) WHERE ID_PRODUKCIYA='$nameProduct'");
        $this->queryQuery("UPDATE sostav SET SUMMA=CENA*KOLVO WHERE CENA > 0 WHERE ID_PRODUKCIYA='$nameProduct'");
        $this->queryQuery("UPDATE `produkciya` AS pr SET pr.SEBEST=(SELECT SUM(sos.SUMMA) FROM sostav AS sos WHERE sos.ID_PRODUKCIYA=pr.ID_SOSTAV) WHERE PRODUKT='$nameProduct'");
        $this->queryQuery("UPDATE `produkciya` SET NACENKA = ((CENA/SEBEST)-1)*100 WHERE SEBEST > 0 AND PRODUKT='$nameProduct'");
    }
    public function deleteProductSostav($id, $nameProduct){
        $this->deleteQuery("`sostav`", "ID", $id);
        $this->RascetCenToProduct($nameProduct);
    }
    public function updateCenaSostav($id, $newCena){
        $this->updateQuery("`produkciya`", "CENA='$newCena'", "ID", $id);
    }
    public function getKategoriiArray(){
        $result = $this->setQuery("SELECT KAT FROM kategorii ORDER BY KAT");
        return $result;
    }
    public function updateKat($id, $newKat){
        $result = $this->updateQuery("`produkciya`","KATEGORIYA='$newKat'", "ID",$id);
        return $result;
    }
}