<?php
class SalesClass extends Card{
    /**
     *  возвращает массив данных из таблицы PRODAZI + доставка function
     *
     * @param [date] $date_start
     * @param [date] $date_stop
     * @return $result[]
     */
    public function getSalesArray($date_start, $date_stop){
        $date_start = date("Y-m-d", strtotime($date_start));
        $date_stop = date("Y-m-d", strtotime($date_stop));
        $result = $this->dbp->setQuery("SELECT ID, SUM(ITOGO), SUM(SKIDKA), DATE_POK, max(TIME_POK) FROM prodazi WHERE DATE_POK BETWEEN CAST('$date_start' AS DATE) AND CAST('$date_stop' AS DATE) GROUP BY ID, DATE_POK ORDER BY ID DESC LIMIT 100");
        if ($result){
            return $result;
        }
    }
    /**
     * возвращает проданную продукцию по номеру чека
     *
     * @param [int] $idcek
     * @return void
     */
    public function getSalesListProduktArray($idcek){
        $result = $this->dbp->setQuery("SELECT * FROM prodazi WHERE ID = '$idcek' ORDER BY TIME_POK DESC");
        if($result){
            return $result;
        }
    }
    public function getDostavka($idcek){
        $result = $this->dbp->setQuery("SELECT SUMMA FROM dostavka WHERE ID_CEK=$idcek");
        if($result){
            return $result;
        }
    }
    public function setVozvratProdukcii($id, $colvo){
        if ($colvo > 1){
            $colvo=$colvo-1;
            $this->dbp->updateQuery("`prodazi`","COLVO=$colvo ,ITOGO=CENA*$colvo", "ID_R",$id);
            return 0;
        }else{
            $idcek = $this->dbp->setQuery("SELECT ID FROM `prodazi` WHERE ID_R=$id")[0][0];
            $this->dbp->deleteQuery("`prodazi`", "ID_R", $id);
            $this->dbp->deleteQuery("`ceki`", "NUMCEK", $idcek);
            return 1;
        }
    }
    public function deleteDostavka($id_cek){
        $this->dbp->deleteQuery("`dostavka`","ID_CEK",$id_cek);
    }
    public function addDostavka($id_cek){
        $summaDostavki = $this->dbp->setQuery("SELECT DOSTAVKA_SUMM FROM setting_pr WHERE id=1")[0][0];
        $dataDostavki = date("Y-m-d");
        $this->dbp->insertQuery("`dostavka`","SUMMA, DATA_DOS, ID_CEK", "'$summaDostavki', '$dataDostavki', '$id_cek'");
    }
    public function getSummaDostavki(){
        $summaDostavki = $this->dbp->setQuery("SELECT DOSTAVKA_SUMM FROM setting_pr WHERE id=1");
        return $summaDostavki[0][0];
    }
}
