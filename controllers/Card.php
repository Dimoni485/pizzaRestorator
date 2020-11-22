<?php
include 'models/Db.php';
class Card{
    public $dbp;

    function __construct()
    {
        $this->dbp = new Db;
    }

    public function getCriticalSkladCountList(){
        $criticalSkladArray = $this->dbp->setQuery("SELECT PRODUKT, KOLVO, ED_IZ FROM sklad WHERE KOLVO < 1 ORDER BY KOLVO LIMIT 10");
        return $criticalSkladArray;
    }

    public function getTableSales($date){
        $result = $this->dbp->setQuery("SELECT PRODUKT,CENA, SUM(COLVO) AS COLVO, SUM(ITOGO) AS ITOGO FROM prodazi WHERE DATE_POK = '".$date."' GROUP BY PRODUKT, CENA");
        return $result;
    }

    public function getCheckColvo($date_start, $date_stop){
        $result =$this->dbp->setQuery("SELECT COUNT(*) AS COUNT FROM ceki WHERE DATAPOK BETWEEN CAST('$date_start' AS DATE) AND CAST('$date_stop' AS DATE)");
        if ($result){
            return $result;
        }else{
            return 0;
        }
    }
    public function getSummaProdazFromData($date_start, $date_stop){
        $result = $this->dbp->setQuery("SELECT SUM(ITOGO) AS SUMMAITOGO FROM prodazi WHERE DATE_POK BETWEEN CAST('$date_start' AS DATE) AND CAST('$date_stop' AS DATE)");
        if ($result){
            return $result;
        }else{
            return 0;
        }
    }
    public function getTopSalesDate($date_start, $date_stop){
        $result = $this->dbp->setQuery("SELECT PRODUKT AS PRODUKT, SUM(COLVO) AS COLVO, SUM(ITOGO) AS ITOG FROM prodazi WHERE DATE_POK BETWEEN CAST('$date_start' AS DATE) AND CAST('$date_stop' AS DATE) GROUP BY PRODUKT ORDER BY ITOG DESC LIMIT 10");
        if ($result){
        return $result;
        }else{
            return 0;
        }
    }
    public function getRashodProduct($date_start, $date_stop){
        $result = $this->dbp->setQuery("SELECT sum(produkciya.SEBEST) FROM prodazi, produkciya WHERE prodazi.PRODUKT=produkciya.PRODUKT AND prodazi.DATE_POK BETWEEN CAST('$date_start' AS DATE) AND CAST('$date_stop' AS DATE)");
        if ($result){
            return $result;
        }
    }
    /**
     *  возвращает массив данных из таблицы PRODAZI + доставка function
     *
     * @param [date] $date_start
     * @param [date] $date_stop
     * @return $result[]
     */
    public function getSalesArray($date_start, $date_stop){
        $result = $this->dbp->setQuery("");
        return $result;
    }
}

//$card = new Card;
//print_r($card ->getTableSales(date('Y-m-d')));