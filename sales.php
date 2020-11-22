<?php
require_once ("header.php");
if (!isset($_GET['datastart'])){
    $datestart=date("d.m.Y");
}else{
    $datestart=$_GET['datastart'];
}
if (!isset($_GET['datastop'])){
	$datestop=date("d.m.Y");
}else{
	$datestop=$_GET['datastop'];
}
$Sales = new SalesClass;
$SalesArray = $Sales->getSalesArray($datestart, $datestop);
if (isset($_POST['vozvrat'])){
	$Sales->setVozvratProdukcii($_POST['vozvrat'], $_POST['colvo']);
}
if (isset($_POST['deletedostavka'])){
	$Sales->deleteDostavka($_POST['deletedostavka']);
}
if (isset($_POST['add_dostavka'])){
	$Sales->addDostavka($_POST['add_dostavka']);
}
?>
<div class="container">
<div class="row mb-1">
	<div class="col-8">
		<div class="input-group input-group-sm mb-1">
			<div class="input-group-prepend">
				<span class="input-group-text">Период: </span>
			</div>
			<input type='date' max="<?php echo date("Y-m-d");?>" class='form-control' data-date-format="dd.mm.yyyy" id='datepicker' value='<?php echo date("Y-m-d",strtotime($datestart)); ?>' />
			<input type='date' max="<?php echo date("Y-m-d");?>" class='form-control' data-date-format="dd.mm.yyyy" id='datepicker2'  value='<?php echo date("Y-m-d", strtotime($datestop)); ?>' />
			<div class="input-group-append">
			<a href="#" class='btn btn-success' onclick="javascript:filter();return false;" id='set_per'>Фильтр</a>
			</div>
		</div>
            <h4><span class="badge badge-info">Итого: <span id="itogovayaSumma"><?=$Sales->getSummaProdazFromData($datestart, $datestop)[0][0]?></span> р.</span> <span class="badge badge-info">Чеков: <span id="colvoCekov"><?=$Sales->getCheckColvo($datestart, $datestop)[0][0]?></span></span></h4>
	</div>
	<div class="col">
		<a href="#" onclick="javascript:setdateday()" class="btn btn-info btn-sm">Сегодня</a>
		<a href="#" onclick="javascript:setdateweek()" class="btn btn-info ml-2 btn-sm">Неделя</a>
		<a href="#" onclick="javascript:setdatemon()" class="btn btn-info ml-2 btn-sm">Месяц</a>
		<a href="#" onclick="javascript:setdateyear()" class="btn btn-info ml-2 btn-sm">Год</a>
	</div>
</div>


<div class="row">
	<table class="table table-hover table-sm">
		<tbody>
			<?php if ($SalesArray){foreach($SalesArray as $rows){?>
			<tr id="position<?=$rows[0]?>">
				<td colspan=8 style='background:#DEE0C8;font-size:1.5em;'>
				<span class="badge badge-light">Чек № <?=$rows[0]?></span> <span class="badge badge-light">Дата продажи: <?=date("d.m.Y",strtotime($rows[3]))?> <?=$rows[4] //время продажи?></span> <span class="badge badge-light">Сумма по чеку: <span id="summaPoCeku<?=$rows[0]?>"><?=$rows[1]?></span> р.</span><?php if ($rows[2]>0){echo " <span class='badge badge-light'>Скидка ".$rows[2]."р.</span>";}?>
				<?php $summaDostavki = $Sales->getDostavka($rows[0]);?>
				<span id=dostavka<?=$rows[0]?>>
				<?php if (isset($summaDostavki[0][0]) && $summaDostavki[0][0] > 0){?>	
				<span class="badge badge-light">доставка <span class="summaDostavki<?=$rows[0]?>"><?=$summaDostavki[0][0]?></span> р.</span> 
					<a class='btn btn-sm btn-danger' title='Убрать доставку' href='#' onclick='javascript:deldostavka(<?=$rows[0]?>,<?=$Sales->getSummaDostavki()?>);return false;'>Убрать доставку</a>
				<?php }else{ ?>
					<a class='btn btn-sm btn-success' href='#' title='Добавить доставку' onclick='javascript:add_dostavka(<?=$rows[0]?>,<?=$Sales->getSummaDostavki()?>);return false;'>Добавить доставку</a>
					<?php } ?>
				</span>
				</td>
			</tr>
		<tr class="thead-light" id="position2<?=$rows[0]?>">
			<th>Номенклатура</th><th>Цена</th><th>Кол-во</th><th>Итого</th><th>Возврат</th>
		</tr>
			<?php $listProdukt = $Sales->getSalesListProduktArray($rows[0]); ?>
				<?php foreach ($listProdukt as $rowsProdukt){?>
			<tr id="rowsProdukt<?=$rowsProdukt[0]?>">
				<td><?=$rowsProdukt[2] //Наименование?></td>
				<td> <span id="cena<?=$rowsProdukt[0]?>"><?=number_format($rowsProdukt[3],2,","," ")."</span> р." //цена?></td>
				<td> <span id="colvo<?=$rowsProdukt[0]?>"><?=$rowsProdukt[6] //количество?></span></td>
				<td> <span id="summa<?=$rowsProdukt[0]?>"><?=number_format($rowsProdukt[7],2,","," ")."</span> р." //сумма?></td>
				<td>
					<a href='#' class="btn btn-sm btn-info" onclick='vozvrat("<?=$rowsProdukt[0]?>",<?=$rows[0]?>);return(false);'>Возврат</a>
				</td>
			</tr>
				<?php }?>
			<?php } }?>
		</tbody>
	</table>
</div>
</div>
<?php require_once ("footer.php");?>