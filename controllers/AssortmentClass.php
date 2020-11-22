<?php
include "models/Db.php";
class AssortmentClass extends Db{
    public function getKategoriiArray(){
        $result = $this->setQuery("SELECT KAT FROM kategorii ORDER BY KAT");
        return $result;
    }
    public function getAssortmentIfKat($katname=null){
        if ($katname==null){
            $result = $this->setQuery("SELECT * FROM produkciya ORDER BY KATEGORIYA, PRODUKT");
            return $result;
        }else{
            $result = $this->setQuery("SELECT * FROM produkciya WHERE KATEGORIYA = '$katname' ORDER BY PRODUKT");
            if ($result){
                return $result;
            }
        }
    }
    public function addProductTo($newname, $newkat, $newcena){
        $this->insertQuery("`produkciya`", "PRODUKT, CENA, ID_SOSTAV, KATEGORIYA, SEBEST, NACENKA","'$newname', $newcena, '$newname', '$newkat', 0 ,0");
    }

    public function RascetCen(){
        $this->queryQuery("UPDATE sostav AS sos SET CENA=(SELECT CENA FROM sklad AS pr WHERE pr.PRODUKT=sos.PRODUKT)");
        $this->queryQuery("UPDATE sostav SET SUMMA=CENA*KOLVO WHERE CENA > 0");
        $this->queryQuery("UPDATE `produkciya` AS pr SET pr.SEBEST=(SELECT SUM(sos.SUMMA) FROM sostav AS sos WHERE sos.ID_PRODUKCIYA=pr.ID_SOSTAV)");
        $this->queryQuery("UPDATE `produkciya` SET NACENKA = ((CENA/SEBEST)-1)*100 WHERE SEBEST > 0");
    }
    public function srNacenka(){
        $result = $this->setQuery("SELECT AVG(NACENKA) FROM `produkciya`");
        if ($result){
            return $result;
        }
    }
    public function deleteProduct($id){
        $result = $this->deleteQuery("`produkciya`", "ID", $id);
        if ($result){
            return $result;
        }
    }
}