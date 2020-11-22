<?php
require_once("connect.php");
$check_cena_rashod=ibase_query("SELECT ID FROM RASHOD_PRODUKT WHERE CENA=0 OR CENA IS NULL ORDER BY ID");
$cena_nul_count=ibase_fetch_assoc($check_cena_rashod);
if ($cena_nul_count > 0){
	echo "
	<a href='#' onclick=\"javascript:$('.produkt_bez_cena').css('display','inline');\"><center><span style='font-family:arial;color:red;'>
	<b>хлечряъ опндсйрш я мехгбеярмшлх жемюлх, сйюфхре ярнхлняэ опндсйрнб</b></span></center></a>
	<div class=produkt_bez_cena>
		<center><a href='#' onclick=\"javascript:$('.produkt_bez_cena').css('display','none');\">яБЕПМСРЭ</a></center>
	<table class='tableall' style='margin: 5px auto;'>
	<thead>
	<tr>
	<th><b>мюхлемнбюмхе ОПНДСЙРЮ</b></th>
	<th><b>йнк-бн</b></th>
	<th><b>жемю</b></th>
	<th><b>хрнцн</b></th>
	<th><b>дюрю опндюфх</b></th>
	<th><b>янупюмхрэ</b></th>
	</tr>
	</thead>
	<tbody>";

	$rashod_nol=ibase_query("SELECT FIRST 10 * FROM RASHOD_PRODUKT WHERE CENA=0 OR CENA IS NULL ORDER BY ID");
	while ($rashod_nol_row=ibase_fetch_assoc($rashod_nol)) {
		echo "<tr>";
		echo "<td>".$rashod_nol_row['PRODUKT']."</td>";
		echo "<td class='colvo_rashod_".$rashod_nol_row['ID']."'>".number_format($rashod_nol_row['KOLVO'],2)."</td>";

		echo "<td> <select onchange='javascript:changecena(".$rashod_nol_row['ID'].");'  style='border-bottom: 1px dotted red;font-size:15px; width:60px;' class='input_cena".$rashod_nol_row['ID']."' >
				<option >".$rashod_nol_row['CENA']."</option>";
		$cena_sklad_produkta=ibase_query("SELECT DISTINCT CENA FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$rashod_nol_row['PRODUKT']."'");
		while ($row_cena_sklad_produkt=ibase_fetch_assoc($cena_sklad_produkta)){
			echo "<option>".number_format($row_cena_sklad_produkt['CENA'],2)."</option>";
		}

		echo "</select></td>";

		echo "<td class='itog_cena_".$rashod_nol_row['ID']."'>".number_format($rashod_nol_row['ITOGO'],2)."</td>";
		echo "<td>".$rashod_nol_row['DATA_PROD']."</td>";
		echo "<td><a href='#' onclick='javascript:updatecena(\"".$rashod_nol_row['ID']."\",\"".$rashod_nol_row['PRODUKT']."\");return(false);'><img src='arrows.png' width='25px'></a></td>";
		echo "</tr>";
			
	}
	echo '
	  </tbody>
	  <tfoot>
	  </tfoot>
	 
	  </table>
	  </div>
	    <script>
	    function updatecena($idcenaprodukt,$produktname){
	$.ajax({
		type:"POST",
		url:"alertrsklad.php",
		data: "idcena="+$idcenaprodukt+"&cenaprodukta="+$(".input_cena"+$idcenaprodukt).val(),
		success: function (data){
			otchet();
			
		}

	});

	        }
	function changecena($chan_cena_id){
		$(".itog_cena_"+$chan_cena_id).text($(".colvo_rashod_"+$chan_cena_id).text()*$(".input_cena"+$chan_cena_id).val());
	}
	  </script>';
}
?>