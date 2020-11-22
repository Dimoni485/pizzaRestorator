<?php
require_once 'connect.php';
$date_today = date('Y-m-d');
?>
<div class="row justify-content-center mt-2">
    <div class="col-10 mb-2">
        <button class="btn btn-success" onclick="location.reload();">Обновить</button>
        <a href="/prodazi" class="btn btn-link">Продажи</a>
        <a href="/analitika" class="btn btn-link">Аналитика</a>
    </div>
    <div class="card col-10 mb-2 mt-2">
        <div class="card-header">
        <button class="btn btn-link" data-toggle="collapse" data-target="#prodazcollapse" aria-expanded="true" aria-controls="collapseOne">
            Продажи сегодня <span class="oi oi-chevron-bottom" title="icon name" aria-hidden="true"></span>
        </button>
        </div>
        <div class="card-body collapse" id="prodazcollapse">

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
                <?php
                $itog_cena_tovara=0;
                $itog_colvo_tovara=0;
                $itog_dohod=0;
                $itog_itogo_tovara=0;
                $itogo_sebest_produkt=0;
                $produkt_name_prod="";
                $tablica_tovara=mysqli_query($dbm,"select DISTINCT PRODUKT,CENA, SUM(COLVO) AS COLVO, SUM(ITOGO) AS ITOGO FROM PRODAZI WHERE DATE_POK = '".$date_today."' GROUP BY PRODUKT, CENA");
                while ($Row_tab_tovara=mysqli_fetch_assoc($tablica_tovara)) {

                    echo "<tr>";
                    echo "<td>".$Row_tab_tovara['PRODUKT']."</td>";

                    echo "<td>".number_format($Row_tab_tovara['CENA'],2,',','')."р."."</td>";
                    $itog_cena_tovara=$itog_cena_tovara+$Row_tab_tovara['CENA'];

                    echo "<td>".$Row_tab_tovara['COLVO']."</td>";
                    $itog_colvo_tovara=$itog_colvo_tovara+$Row_tab_tovara['COLVO'];

                    echo "<td>".number_format($Row_tab_tovara['ITOGO'],2,',','')."р."."</td>";
                    $itog_itogo_tovara=$itog_itogo_tovara+$Row_tab_tovara['ITOGO'];

                    $sebest_produkt_tab=mysqli_query($dbm,"SELECT SUM(ITOGO) AS SUMMA FROM RASHOD_PRODUKT WHERE ID_PRODUKCIYA='".$Row_tab_tovara['PRODUKT']."' AND DATA_PROD = '".$date_today."'");
                    while ($sebect_produkt=mysqli_fetch_assoc($sebest_produkt_tab)) {
                        echo "<td>".number_format($sebect_produkt['SUMMA'],2,',','')."р."."</td>";
                        $itogo_sebest_produkt=$itogo_sebest_produkt+$sebect_produkt['SUMMA'];
                        echo "<td>".number_format($Row_tab_tovara['ITOGO']-$sebect_produkt['SUMMA'],2,',','')."р."."</td>";
                        $dohod=($Row_tab_tovara['ITOGO']-$sebect_produkt['SUMMA']);
                        $itog_dohod=$itog_dohod+$dohod;
                    }

                    echo "</tr>";
                }

                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th><b>ИТОГО:</b></th>
                    <th>
                        <b>
                            <?php
                            if (isset($itog_cena_tovara)){
                                echo number_format($itog_cena_tovara,2,',','')."р.";
                            }
                            ?>
                        </b></th>
                    <th><b>
                            <?php
                            if (isset($itog_colvo_tovara)){
                                echo $itog_colvo_tovara;
                            }
                            ?>
                        </b></th>
                    <th><b>
                            <?php
                            if (isset($itog_itogo_tovara)){
                                echo number_format($itog_itogo_tovara,2,',','')."р.";
                            }
                            ?>
                        </b></th>
                    <th><b>
                            <?php
                            if (isset($itogo_sebest_produkt)){
                                echo number_format($itogo_sebest_produkt,2,',','')."р.";
                            }
                            ?>
                        </b></th>
                    <th><b>
                            <?php
                            if (isset($itog_dohod)){
                                echo number_format($itog_dohod,2,',','')."р.";
                            }
                            ?>
                        </b></th>
                </tr>
                </tfoot>
            </table>


        </div>
    </div>

<div class="card bg-light col-5">
    <div class="card-body">
        <h5 class="card-title">Итого сегодня:</h5>
            <span class="badge badge-info mb-2">
            Чеков: <?php
            $query_kolvo_cekov=mysqli_query($dbm,"SELECT COUNT(*) AS COUNT FROM CEKI WHERE DATAPOK='".$date_today."'");
            $kolva_cekov=mysqli_fetch_assoc($query_kolvo_cekov);
            echo $kolva_cekov['COUNT'];
        ?>
            </span>

        <h6 class="card-subtitle text-muted"><?php echo date('d.m.Y'); ?> г.</h6>

        <?php
        $query_summa_virucki=mysqli_query($dbm,"select SUM(ITOGO) AS SUMMAITOGO FROM PRODAZI WHERE DATE_POK='".$date_today."'");
        $summa_virucki=mysqli_fetch_assoc($query_summa_virucki);
        $summa_virucki=$summa_virucki['SUMMAITOGO'];
        if ($summa_virucki <=0){
            $summa_virucki = 0;
        }else{

        }
        ?>
        <p class="card-text" style="font-size: 3em;"><?php echo number_format($summa_virucki,2,',',' '); ?> р.</p>


    </div>
</div>
<div class="card bg-light col-5 ml-2">
    <div class="card-body">
        <h5 class="card-title">Итого за месяц:</h5>
            <span class="badge badge-info mb-2">
                Чеков: <?php
                $query_kolvo_cekov=mysqli_query($dbm,"SELECT COUNT(*) AS COUNT FROM CEKI WHERE DATAPOK >= '".date('Y-m-01')."' AND DATAPOK <= '".$date_today."'");
                $kolva_cekov=mysqli_fetch_assoc($query_kolvo_cekov);
                echo $kolva_cekov['COUNT'];
                ?>
            </span>

        <h6 class="card-subtitle mb-2 text-muted"><?php echo date('m.Y'); ?></h6>
        <?php
        require_once 'connect.php';
        $query_summa_virucki=mysqli_query($dbm,"select SUM(ITOGO) AS SUMMAITOGO FROM PRODAZI WHERE DATE_POK >= '".date('Y-m-01')."' AND DATE_POK <= '".$date_today."'");
        $summa_virucki=mysqli_fetch_assoc($query_summa_virucki);
        $summa_virucki=$summa_virucki['SUMMAITOGO'];
        if ($summa_virucki <=0){
            $summa_virucki = 0;
        }else{

        }
        ?>
        <p class="card-text" style="font-size: 3em;"><?php echo number_format($summa_virucki,2,',',' '); ?> р.</p>

    </div>
</div>
    <div class="card bg-light col-5 mt-2">
        <div class="card-header bg-warning">
            Критический запас на складе
        </div>
        <div class="card-body">

            <table class="table table-sm table-hover" style="font-size: 12px;">
                <?php
                $query_sklad=mysqli_query($dbm,"SELECT PRODUKT, KOLVO FROM SKLAD WHERE KOLVO < 1 ORDER BY PRODUKT LIMIT 10");
                while ($Row=mysqli_fetch_assoc($query_sklad)) {
                    echo "<tr>";
                echo "<td>";
                    echo $Row['PRODUKT'];

                echo "</td>";
                    echo "<td>";
                    echo number_format($Row['KOLVO'],2,',', ' ');

                    echo "</td>";
                echo "</tr>";
                }
                ?>
            </table>
            <a href="/sklad" class="card-link">Подробнее...</a>
        </div>


    </div>
    <div class="card col-5 bg-light mt-2 ml-2">
        <div class="card-header bg-info">
            Топ продаж за месяц
        </div>
        <div class="card-body">

            <table class="table table-sm table-hover" style="font-size: 12px;">
                <?php
                $query_sklad=mysqli_query($dbm,"SELECT DISTINCT(PRODUKT) AS PRODUKT, SUM(COLVO) AS COLVO FROM PRODAZI WHERE DATE_POK >= '".date('Y-m-01')."' AND DATE_POK <= '".$date_today."' GROUP BY PRODUKT ORDER BY COLVO DESC LIMIT 10");
                while ($Row=mysqli_fetch_assoc($query_sklad)) {
                    echo "<tr>";
                    echo "<td>";
                    echo $Row['PRODUKT'];

                    echo "</td>";
                    echo "<td>";
                    echo $Row['COLVO'];

                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <a href="/prodazi" class="card-link">Подробнее...</a>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        /*setInterval('location.reload()',10000);*/
    });

</script>