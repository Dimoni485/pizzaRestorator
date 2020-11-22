<?php 
include "header.php";
$settingClass = new SettingsClass;
$setting = $settingClass->getSettings();
?>
<div class="container">
    <div class="row">
        <div class="col-6">
            <label>Наименование предприятия:</label><input class ="form-control" type="text" value="<?=$setting[0][0]?>">
                <label>Наименование юр. лица:</label><input class ="form-control" type="text" value="<?=$setting[0][0]?>">
                <label>Адрес:</label><input class ="form-control" type="text" value="<?=$setting[0][1]?>">
                <label>ИНН:</label><input class ="form-control" type="text" value="<?=$setting[0][2]?>">
                <label>Телефон:</label><input class ="form-control" type="text" value="<?=$setting[0][3]?>">
                <label>Печатать в конце чека:</label><textarea class ="form-control" type="text"><?=$setting[0][4]?></textarea><br>
                <button class="btn btn-sm btn-success">Сохранить</button>
                <br><br>
                <label>Сумма доставки:</label><input class ="form-control" type="number" value="<?=$setting[0][5]?>"><br>
                <button class="btn btn-sm btn-success">Сохранить</button>
                
        </div>
        <div class="col-6">
            <label>Пример чека:</label><textarea class="form-control">

            </textarea>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>