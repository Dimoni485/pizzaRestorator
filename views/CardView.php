<?php
include 'controllers/Card.php';
class CardView{
    public $today;
    public $date_start;
    public $date_stop;
    private $card;
    function __construct(){
        $this->card = new Card;
    }

    public function getCritikalSkladListProdukt(){
        $rows = $this->card->getCriticalSkladCountList();
        echo '<table class="table table-sm table-hover" style="font-size: 12px;">';
        foreach($rows as $views){ 
                echo "<tr>";
                echo "<td>";
                echo $views[0];
                echo "</td>";
                echo "<td>";
                echo number_format($views[1],2,',', ' ');
                echo "</td>";
                echo "<td>";
                echo $views[2];
                echo "</td>";
                echo "</tr>";
        }
        echo '</table>';
    }
    public function getSalesNow($today){
        $rows = $this->card->getTableSales($today);
        echo '
        <table class="table table-hover table-sm" style="font-size: 12px;">
                <thead>
                <tr>
                    <th><b>НАИМЕНОВАНИЕ</b></th>
                    <th><b>ЦЕНА</b></th>
                    <th><b>КОЛЛИЧЕСТВО</b></th>
                    <th><b>ВЫРУЧКА</b></th>
                    <th><b>СЕБЕСТОИМОСТЬ</b></th>
                    <th><b>ДОХОД</b></th>
                </tr>
                </thead>
                <tbody>
        ';
        foreach($rows as $views){
                    echo "<tr>";
                    echo "<td>".$views[0]."</td>";
                    echo "<td>".number_format($views[1],2,',','')."р."."</td>";
                    echo "<td>".$views[2]."</td>";
                    //$itog_colvo_tovara=$itog_colvo_tovara+$Row_tab_tovara['COLVO'];

                    echo "<td>".number_format($views[3],2,',','')."р."."</td>";
                    //$itog_itogo_tovara=$itog_itogo_tovara+$Row_tab_tovara['ITOGO'];
                    echo "</tr>";
        }
        
                echo '</tbody>
                <tfoot>
                <tr>
                    <th><b>ИТОГО:</b></th>
                    <th>
                        <b>';
                                //echo number_format($itog_cena_tovara,2,',','')."р.";
                        echo '</b></th><th><b>';
                                //echo $itog_colvo_tovara;
                        echo '</b></th><th><b>';
                                //echo number_format($itog_itogo_tovara,2,',','')."р.";
                        echo '</b></t><th><b>';
                                //echo number_format($itogo_sebest_produkt,2,',','')."р.";
                        echo '</b></th><th><b>';
                                //echo number_format($itog_dohod,2,',','')."р.";
                        echo '</b></th></tr>';
                echo '</tfoot>
            </table>';

    }
    public function getCheckColvoView($date_start, $date_stop){
       $result = $this->card->getCheckColvo($date_start, $date_stop);
       return $result[0][0];
    }

    public function getSummaItogoView($date_start, $date_stop){
        $result = $this->card->getSummaProdazFromData($date_start, $date_stop);
        return $result[0][0];
    }

    public function getTopSalesDateView($date_start, $date_stop){
        $rows = $this->card->getTopSalesDate($date_start, $date_stop);
        echo '<table class="table table-sm table-hover" style="font-size: 12px;">';
        if ($rows){
        foreach ($rows as $views){
            echo "<tr>";
                    echo "<td>";
                    echo $views[0];
                    echo "</td>";
                    echo "<td>";
                    echo number_format($views[1], 2, ',',' ');
                    echo "</td>";
                    echo "<td>";
                    echo number_format($views[2], 2, ',',' ')." р.";
                    echo "</td>";
                    echo "</tr>";
        }
        echo '</table>';
    }}
    public function getRashodProduct($date_start, $date_stop){
            $result=$this->card->getRashodProduct($date_start, $date_stop);
            if ($result){
                    return $result[0][0];
            }
    }
}
