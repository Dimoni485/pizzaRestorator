
<script type="text/javascript">
    $(function() {
        $( "#datepicker" ).datepicker({
            locale:'ru-ru',
            format: "yyyy-mm-dd",
            uiLibrary:'bootstrap4'
        });
        $( "#datepicker2" ).datepicker({
            locale:'ru-ru',
            format: "yyyy-mm-dd",
            uiLibrary:'bootstrap4'
        });
    });
</script>
<nav class="navbar">
    <?php

    if (!isset($_POST['datastart'])){
        $datestart=date("Y-m-d");
    }else{
        $datestart=$_POST['datastart'];
    }

    if (!isset($_POST['datastop'])){
        $datestop=date("Y-m-d");
    }else{
        $datestop=$_POST['datastop'];
    }
    if (!isset($_POST['produktname'])){
        $produktname='';
    }else{
        $produktname=$_POST['produktname'];
    }
    echo "<span class='badge badge-info'>".$produktname."</span>";
echo "<form class='form-inline'>";
    echo "<span class='mr-2'>Период: с </span>";
    echo "<input type='text' id='datepicker' value=".$datestart.">";
    echo "<sapan class='mr-2 ml-2'> по</sapan> ";
    echo "<input type='text' id='datepicker2'  value=".$datestop.">";

    echo "<select class='form-control mr-2 ml-2' id='selprodukt' rev='111'>";
    require_once '../connect.php';
    if (!$produktname){

        echo "<option>Выбрать из списка</option>";
    }else {
        echo "<option>" . $produktname . "</option>";
        echo "<option disabled>Выбрать из списка</option>";
    }
    $select_produkt=mysqli_query($dbm,'SELECT PRODUKT FROM PRODUKCIYA ORDER BY PRODUKT');
    while ($Row_pr_sel=mysqli_fetch_assoc($select_produkt)){
        echo "<option >".$Row_pr_sel['PRODUKT']."</option>";
    }
    echo "</select>";
    ?>
    <button class="btn btn-success ml-2" onclick="javascript:setperiod_prod();return(false);">Применить</button>
</form>
</nav>
<table class="table table-light" id="tableall">
    <thead>
    <tr>
        <th>Продукция</th>
        <th>Кол-во</th>
        <th>Дата продажи</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $tablica_body=mysqli_query($dbm,"select PRODUKT,DATE_POK FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."') AND (PRODUKT='".$produktname."') GROUP BY DATE_POK, PRODUKT ORDER BY DATE_POK");
    while ($Row_tab_body=mysqli_fetch_assoc($tablica_body)) {
        echo "<tr>";
        echo "<td>".$Row_tab_body['PRODUKT']."</td>";
        $tablica_data_produkt=mysqli_query($dbm,"select SUM(COLVO) AS KOLVO FROM PRODAZI WHERE (DATE_POK = '".$Row_tab_body['DATE_POK']."') AND (PRODUKT='".$Row_tab_body['PRODUKT']."') GROUP BY PRODUKT");
        while ($Row_tab_data_produkt=mysqli_fetch_assoc($tablica_data_produkt)) {
            echo "<td>".$Row_tab_data_produkt['KOLVO']."</td>";
            echo "<td>".$Row_tab_body['DATE_POK']."</td>";
            echo "</tr>";
        }

    }

    ?>
    </tbody>
</table>
<script type="text/javascript">
    function setperiod_prod()
    {
        fd=$("#datepicker").val();
        fdd=$("#datepicker2").val();

        $.ajax({
            type:'POST',
            url:'prodaza_produkciya.php',
            data:'datastart='+fd+'&datastop='+fdd+'&produktname='+$('#selprodukt').val(),
            success: function (data){
                $('.contenttab').html(data);

            }

        });

    }
</script>
