function filter()
{
  $fs=$("#datepicker").val();
  $fss=$("#datepicker2").val();
  $(location).attr('href','sales.php?datastart=' +  $fs + '&datastop=' + $fss);
}
function setdateweek()
{
  var datenow = new Date();
  var daynow = datenow.getDate()-7;
  $datestop=datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-'+(datenow.getDate());
  if (daynow <=0)
  {
    daynow=1; 
  }
  $fd=datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-'+(daynow);
  $(location).attr('href','sales.php?datastart=' +  $fd+ '&datastop=' + $datestop);
  
 }
function setdatemon()
  {
  var datenow = new Date();
  $datestop = datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-'+(datenow.getDate());
  $fd=datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-01';
      $(location).attr('href','sales.php?datastart=' +  $fd+ '&datastop=' + $datestop);
  
  }
function setdateday()
  {
  var datenow = new Date();
  $datestop = datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-'+(datenow.getDate());
  $fd=datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-'+(datenow.getDate());
      $(location).attr('href','sales.php?datastart=' +  $fd+ '&datastop=' + $datestop);
  
  }
  
  
  
function setdateyear()
  {
  var datenow = new Date();
  $datestop = datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-'+datenow.getDay();
  $fd=(datenow.getFullYear()-1)+'-01-'+'01';
      $(location).attr('href','sales.php?datastart=' +  $fd+ '&datastop=' + $datestop);
  
  }
function vozvrat($idprodukt, $idposition)
  {
  if (confirm("Сделать возврат одной еденицы товара ?")){
    var cena = parseFloat($("#cena"+$idprodukt).html());
    var summa = parseFloat($("#summa"+$idprodukt).html());
    var summaPoCeku = parseFloat($("#summaPoCeku"+$idposition).html());
    var result = summa - cena;
    var colicestvo = parseFloat($("#colvo"+$idprodukt).html());
    var itogovayaSumma = parseFloat($('#itogovayaSumma').html());
    var colvoCekov = parseFloat($('#colvoCekov').html());
    $.ajax({
      type: 'POST',
      url:'sales.php',
      data:'vozvrat='+$idprodukt+'&colvo='+colicestvo,
      success: function (data){
          if (colicestvo==1){
            $("#itogovayaSumma").html(itogovayaSumma-cena);
            $("#rowsProdukt"+$idprodukt).remove();
            $("#summaPoCeku"+$idposition).html(summaPoCeku-cena);
            if (summaPoCeku==summa){
              $("#position"+$idposition).remove();
              $("#position2"+$idposition).remove();
              $("#colvoCekov").html(colvoCekov-1);
            }
          }else{
            $("#itogovayaSumma").html(itogovayaSumma-cena);
            $("#summaPoCeku"+$idposition).html(summaPoCeku-cena);
            $("#colvo"+$idprodukt).html(colicestvo-1);
            $("#summa"+$idprodukt).html(result);
          }
      }
      });
  }
  }
function add_dostavka($id_cek, $summaDos){
	$.ajax({
		type: 'POST',
		url:'sales.php',
		data:'add_dostavka='+$id_cek,
		success: function (data){
			$('#dostavka'+$id_cek).html("<span class='badge badge-light'>доставка <span class='summaDostavki"+$id_cek+"'>"+$summaDos+"</span> р.</span><a class='btn btn-sm btn-danger' title='Убрать доставку' href='#' onclick='javascript:deldostavka("+$id_cek+","+$summaDos+");return false;'>Убрать доставку</a>");
		}
		});
}
function deldostavka($id_cek, $summaDos){
	$.ajax({
		type: 'POST',
		url:'sales.php',
		data:'deletedostavka='+$id_cek,
		success: function (data){
            $('#dostavka'+$id_cek).html("<a class='btn btn-sm btn-success' href='#' title='Добавить доставку' onclick='javascript:add_dostavka("+$id_cek+","+$summaDos+");return false;'>Добавить доставку</a>");
		}
		});
}
function addProductToTable($x){
  $x++;
  console.log($x);
  $("#tableProduct").find("tbody").prepend("<tr id='rowsProductNew"+$x+"'><td><input type='text' class='form-control form-control-sm' id='newRowName"+$x+"' autofocus required /></td><td><select class='custom-select custom-select-sm' id='select_categoriya"+$x+"' required>"+kategoriyaList+"</select></td><td>0</td><td><input type='number' id='cenaNewRows"+$x+"' class='form-control form-control-sm' value=0></input></td><td>0</td><td><button class='btn btn-sm btn-success' onclick='javascript:saveProductRows("+$x+");' >Сохранить</button></td><td><button onclick='javascript:removeRows("+$x+");' class='btn btn-sm btn-warning'>Удалить</button></td></tr>");
}
function removeRows($x){
  $("#rowsProductNew"+$x).remove();
  $("#newRows"+$x).remove();
}

function saveProductRows($x){
  $newname = $('#newRowName'+$x).val();
  $newkat = $('#select_categoriya'+$x).val();
  $newcena = $('#cenaNewRows'+$x).val();
  if ($newname!='' & $newkat!='' & $newcena!=''){
  $.ajax({
    type:'POST',
    url:'assortment.php', 
    data: 'save=1&newname='+$newname+'&newkat='+$newkat+'&newcena='+$newcena,
    success: function(data){
      //location.reload();
      $("#rowsProductNew"+$x).html("<td>"+$newname+"</td><td>"+$newkat+"</td><td class='text-right'>0</td><td class='text-right'>"+$newcena+"</td><td class='text-right'>0</td><td><button class='btn btn-sm btn-info disabled'>Редактировать</button></td><td><button class='btn btn-sm btn-info disabled'>Удалить</button></td></tr>");
    }
  });
}else{
  alert("Пустые поля!");
}
}
function rascet_cen(){
  $("#rascetCen").html('<div class="spinner-border text-secondary" role="status"><span class="sr-only">Loading...</span></div>');
  $.ajax({
    type:'POST',
    url:'assortment.php',
    data:'rascetCen=1',
    success: function(data){
      location.reload();
    }
  });
}
function del_tovar($id){
  $.ajax({
    type:'POST',
    url:'assortment.php',
    data:'delete='+$id,
    success: function(data){
      location.reload();
    }
  });
}

function addProductToSostav($x){
  $x++;
  console.log($x);
  $('#sostavTable').find('tbody').prepend('<tr id="newRows'+$x+'"><td><select class="custom-select custom-select-sm" onchange="javascript:changeListSkladProduct('+$x+');" id="select_categoriya'+$x+'" required>'+productList+'</select></td><td><input onkeyup="javascript:changeCenaSkladProduct('+$x+');" type="number" step=0.0001 id="colvoNewRow'+$x+'" class="form-control form-control-sm" value="0"/></td><td id="newCenaRow'+$x+'">0</td><td id="itogoNewRow'+$x+'">0</td><td class="text-center"> <a href="#" onclick="javascript:saveSostav('+$x+');" class="btn btn-sm btn-success">Сохранить</a> <a href="#" class="btn btn-sm btn-warning" onclick="javascript:removeRows('+$x+');console.log('+$x+')">Удалить</a></td></tr>');
}
function saveSostav($x){
  $nameProduct = $("#nameProductSpan").html();
  $nameSostavProdukt = $('#select_categoriya'+$x).val();
  $cenaSelectProdukt =  ArrayCenaProdukta.get($nameSostavProdukt);
  $colvoProduct = parseFloat($("#colvoNewRow"+$x).val());
  console.log($cenaSelectProdukt);
  console.log($nameSostavProdukt);
  if ($nameSostavProdukt!='' | $colvoProduct!=0){
  $.ajax({
    type:'POST',
    url:'productCard.php',
    data:'save=1&nameProduct='+$nameProduct+'&nameSostavProduct='+$nameSostavProdukt+'&cenaSelectProduct='+$cenaSelectProdukt+'&colvoProduct='+$colvoProduct,
    success: function(data){
      $("#newRows"+$x).html("<td>"+$nameSostavProdukt+"</td>"+"<td>"+$colvoProduct+"</td>"+"<td>"+$cenaSelectProdukt+"</td>"+"<td>"+$cenaSelectProdukt*$colvoProduct+"</td>");
    }
  });
}else{
  alert('Заполните все поля.');
}
}
function changeListSkladProduct($x){
  $nameSostavProdukt = $('#select_categoriya'+$x).val();
  $cenaSelectProdukt =  ArrayCenaProdukta.get($nameSostavProdukt);
  $("#newCenaRow"+$x).html(parseFloat($cenaSelectProdukt).toFixed(2));
  changeCenaSkladProduct($x);
}

function changeCenaSkladProduct($x){
  $cenaProduct = parseFloat($("#newCenaRow"+$x).html());
  $colvoProduct = parseFloat($("#colvoNewRow"+$x).val());
  if ($cenaProduct > 0 & $colvoProduct > 0){
    $itogoProduct = $cenaProduct*$colvoProduct;
    $("#itogoNewRow"+$x).html($itogoProduct.toFixed(2));
  }else{
    $("#itogoNewRow"+$x).html(0.00);
  }
}
function deleteRowsSostav($id){
  if(confirm("Удалить ?")){
    $nameProduct = $("#nameProductSpan").html()
  $.ajax({
    type:'POST',
    url:'productCard.php',
    data:'delete='+$id+'&nameProduct='+$nameProduct,
    success:function(){
      $("#sostavTableRows"+$id).remove();
    }
  });
}
}

function editCenaSpan($id){
  $valueCena = $("#productCenaSpan").html();
  if ($("#buttonEditCenaSpan").html()=='Изменить'){
    $("#buttonEditCenaSpan").html("Сохранить");
    $("#productCenaSpan").html("<input type='number' class='form-control form-control-sm' id='inputCenaSostav' step=0.01 value='"+$valueCena+"'>");
  }else{
    $updateCena = $('#inputCenaSostav').val();
    $("#buttonEditCenaSpan").html('Изменить');
    $("#productCenaSpan").html($updateCena);
    $.ajax({
      type:'POST',
      url:'productCard.php',
      data:'updateCena='+$updateCena+'&updateID='+$id,
      success:function(){
        console.log($updateCena);
      }
    });
  }
}
function editSelectKat($id){
  $valueKat = $("#productKatSpan").html();
  if ($("#buttonSelectKat").html()=='Изменить'){
    $("#buttonSelectKat").html("Сохранить");
    $("#productKatSpan").html("<select class='custom-select custom-select-sm' id='selectKat'><option>"+$valueKat+"</option>"+kategoriyaList+"</select>");
  }else{
    $selectKat = $('#selectKat').val();
    $("#buttonSelectKat").html('Изменить');
    $("#productKatSpan").html($selectKat);
   $.ajax({
      type:'POST',
      url:'productCard.php',
      data:'updateKat='+$selectKat+'&saveID='+$id,
      success:function(){
        console.log($selectKat, $id);
      }
    });
  }
  }
  function editStorageColvo($id){
    $("#buttonEditColvo"+$id).html("<a href='#' class='btn btn-sm btn-warning' onclick='javascript:saveStorageColvo("+$id+");return false;'>Сохранить</a>");
    $valueColvo = parseFloat($("#rowsColvo"+$id).html().replace(",","."));
    $("#rowsColvo"+$id).html("<input type='number' id='inputColvo"+$id+"' step=0.0001 class='form-control form-control-sm' value='"+$valueColvo+"'/>");
  }
  function saveStorageColvo($id){
    $inputColvo = $("#inputColvo"+$id).val();
    $.ajax({
      type:'POST',
      url:'storage.php',
      data:'saveColvo='+$inputColvo+'&id='+$id,
      success:function(){
        $("#rowsColvo"+$id).html($inputColvo);
        $("#buttonEditColvo"+$id).html('<a href="#" onclick="javascript:editStorageColvo('+$id+');" class="btn btn-sm btn-info">Изменить кол-во</a>');
      }
    });
  }
  function obnovitCenaStorage(){
    $.ajax({
      type:'POST',
      url:'storage.php',
      data:'updatePriceStorage=1',
      success:function(){
        location.reload();
      }
    });
  }

  function deleteStorageProduct($id){
    if(confirm("Удалить ?")){
    $.ajax({
      type:'POST',
      url:'storage.php',
      data:'delete='+$id,
      success:function(){
        $("#rowsTableStorage"+$id).remove();
      }
    });
  }
  }

  function addNewCheck($checkNum){
    var datenow = new Date();
    $month = ''+(datenow.getMonth()+1);
    $day = ''+(datenow.getDate());
    if ($month.length < 2){
      $month = '0'+$month;
    }
    if ($day.length < 2){
      $day = '0'+$day;
    }
    $dates = datenow.getFullYear()+'-'+$month+'-'+$day;
    console.log($dates);
    console.log($checkNum);
    textHTML = '<div class="card" id="card'+$checkNum+'">';
    textHTML+= '<div class="card-header" id="heading'+$checkNum+'">';
    textHTML+= '<h5 class="mb-0">';
    textHTML+= '<div class="form-inline"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse'+$checkNum+'" aria-expanded="true" aria-controls="collapse'+$checkNum+'">';
  
  
    textHTML+='<span class="badge badge-info">№ '+$checkNum+'</span>';
    textHTML+= '</button><input type="date" id="newRowsDate'+$checkNum+'" class="form-control form-control-sm mr-2 ml-2" value="'+$dates+'"/><a href="#" id="deleteButton'+$checkNum+'" onclick="javascript:deleteStrokaPay('+$checkNum+');" class="btn btn-info btn-sm">Удалить запись</a></div>';
    textHTML+= '</h5>';
    textHTML+= '</div>';

    textHTML+= '<div id="collapse'+$checkNum+'" class="collapse show" aria-labelledby="heading'+$checkNum+'" data-parent="#accordionExample">';
    textHTML+= '<div class="card-body">';
    textHTML+= '<a href="#" class="btn btn-success btn-sm" onclick="javascript:addStrokaCheck('+$checkNum+');return false;">Добавить строку</a>';
    textHTML+= '';
    textHTML+='<table class="table table-light table-sm mt-2" id="tablePay'+$checkNum+'">';
    textHTML+='<thead class="thead-light">';
    textHTML+='<tr>';
    textHTML+='<th>Наименование</th><th>Поставщик</th><th>Ед. из.</th><th>Цена</th><th>Кол-во</th><th>Сумма</th><th colspan=2></th>';
    textHTML+='</tr>';
    textHTML+='</thead>';
    textHTML+='<tbody>';
    textHTML+='</tbody>'
    textHTML+='</table>';
    textHTML+= '</div>';
    textHTML+= '</div>';
    textHTML+= '</div>';
    $("#accordionExample").prepend(textHTML);
  }

  function deleteStrokaPay($checkNum){
    $("#card"+$checkNum).remove();
  }
  var $strokaN=0;
  function addStrokaCheck($checkNum){
    tableHTML="<tr id='rowsPayNew"+$strokaN+"'><td><div class='input-group input-group-sm' id='inputGroup"+$strokaN+"'><select id='selectProductChek"+$strokaN+"' class='custom-select custom-select-sm' onchange='addCenaToInputCheck("+$strokaN+");'><option value=''></option>"+$productSkladList+"</select><div class='input-group-append'><a href='#' onclick='javascript:appendInputForrCheck("+$strokaN+");' class='btn btn-sm btn-success'>+</a></div></div></td>";
    tableHTML+="<td><select class='custom-select custom-select-sm' id='providerCheck"+$strokaN+"'><option></option>"+$postavsikList+"</select></td>";
    tableHTML+="<td><select class='custom-select custom-select-sm' id='edizRows"+$strokaN+"'><option>кг.</option><option>л.</option><option>шт.</option></select></td>";
    tableHTML+="<td><input type='number' id='cenaNewRowsCheck"+$strokaN+"' onkeyup='javascript:keyupNewRowsCheck("+$strokaN+");' class='form-control form-control-sm' step=0.01></td>";
    tableHTML+="<td><input type='number' id='colvoNewRowsCheck"+$strokaN+"' onkeyup='javascript:keyupNewRowsCheck("+$strokaN+");' class='form-control form-control-sm' step=0.0001></td>";
    tableHTML+="<td id='itogoNewRowsCheck"+$strokaN+"'>0</td>";
    tableHTML+="<td><a href='#' onclick='javascript:saveToDBcheck("+$strokaN+","+$checkNum+");return false;' class='btn btn-warning btn-sm'>Сохранить</a></td> <td><a href='#' class='btn btn-info btn-sm' onclick='javascript:deletePayRowsNew("+$strokaN+");return false;'>Удалить</a></td>";
    tableHTML+="</tr>";
    $("#tablePay"+$checkNum).find("tbody").prepend(tableHTML);
    console.log($strokaN);
    $strokaN++;
  }
  function deletePayRowsNew($checkNum){
    $("#rowsPayNew"+$checkNum).remove();
    console.log($checkNum);
  }
  function keyupNewRowsCheck($strokaN){
    $colvoInputCheck = parseFloat($("#colvoNewRowsCheck"+$strokaN).val());
    $cenaInputCheck = parseFloat($("#cenaNewRowsCheck"+$strokaN).val());
    if ($colvoInputCheck >0 & $cenaInputCheck >0){
      $itog = $cenaInputCheck*$colvoInputCheck;
      $("#itogoNewRowsCheck"+$strokaN).html($itog.toFixed(2));
    }else{
      $("#itogoNewRowsCheck"+$strokaN).html('0');
    }

  }
  function addCenaToInputCheck($strokaN){
    $selectProductCheck = $("#selectProductChek"+$strokaN).val();
    $cenaToInput = ArraySkladProduct.get($selectProductCheck);
    $("#cenaNewRowsCheck"+$strokaN).val($cenaToInput);
    $("#providerCheck"+$strokaN).val($selectProductCheck.split("->")[1]);
    console.log($selectProductCheck.split("->")[0]);
    console.log($cenaToInput);
  }
  function appendInputForrCheck($strokaN){
    $("#selectProductChek"+$strokaN).remove();
    $("#inputGroup"+$strokaN).prepend("<input type='text' class='form-control form-control-sm' id='selectProductChek"+$strokaN+"'/>")
  }
  var SummaItogoPoCheck = 0;
  
  function saveToDBcheck($strokaN, $checkNum){
    $newRowsCheckNum = $checkNum;
    $newRowsDate = $("#newRowsDate"+$checkNum).val();
    $newRowsName =$("#selectProductChek"+$strokaN).val();
    $newRowsProvider=$("#providerCheck"+$strokaN).val();
    $newRowsEdIz = $("#edizRows"+$strokaN).val();
    $newRowsColvo = $("#colvoNewRowsCheck"+$strokaN).val();
    $newRowsCena=$("#cenaNewRowsCheck"+$strokaN).val();
    $itogo = parseFloat($newRowsCena)*parseFloat($newRowsColvo);
    if($newRowsName!='' & $newRowsColvo!='' & $newRowsCena!=''){
      SummaItogoPoCheck+=$itogo;
      $.ajax({
        type:'POST',
        url:'goodsProvider.php',
        data:'saveNewCheck=1&numNewCheck='+$newRowsCheckNum+'&dateNewCheck='+$newRowsDate+'&nameNewCheck='+$newRowsName.split("->")[0]+'&providerNewCheck='+$newRowsProvider+'&edizNewCheck='+$newRowsEdIz+'&colvoNewCheck='+$newRowsColvo+'&cenaNewCheck='+$newRowsCena+'&itogoNewCheck='+$itogo,
        success:function(){
          $("#rowsPayNew"+$strokaN).html("<td>"+$newRowsName.split("->")[0]+"</td><td>"+$newRowsProvider+"</td><td>"+$newRowsEdIz+"</td><td>"+$newRowsCena+"</td><td>"+$newRowsColvo+"</td><td>"+$itogo+"</td>");
          $("#deleteButton"+$checkNum).remove();
          $("#newRowsDate"+$checkNum).attr('disabled','');
        }
      });
   
    }else{
      alert('Заполните все поля.');
    }
    console.log($newRowsCheckNum, $newRowsDate, $newRowsName.split("->")[0], $newRowsProvider, $newRowsEdIz, $newRowsColvo, $newRowsCena);
    console.log(SummaItogoPoCheck);
  }
  function deleteCheck($checkNum){
    if(confirm("Удалить ?")){
      $.ajax({
        type:'POST',
        url:'goodsProvider.php',
        data:'deleteCheck='+$checkNum,
        success:function(){
            location.reload();
        }
      });
    }
  }
  function deleteRowsCheck($rowsNum){
    if(confirm("Удалить ?")){
      $.ajax({
        type:'POST',
        url:'goodsProvider.php',
        data:'deleteRowsCheck='+$rowsNum,
        success:function(){
            $("#rowsNum"+$rowsNum).remove();
        }
      });
    }
  }
  function addRowsKat(){
    $("#buttonAddKat").attr('disabled', '');
    $("#tableKat").find("tbody").prepend("<tr id='newRow'><td><input class='form-control form-control-sm' id='newInputKat'/></td><td><a href='#' class='btn btn-warning btn-sm mr-1' onclick='javascript:saveRowsKat();'>Сохранить</a><a href='#' class='btn btn-info btn-sm mr-1' onclick='javascript:deleteRowsKat();'>Удалить</a></td></tr>");
  }
  function saveRowsKat(){
   if ($("#newInputKat")!=''){
     $.ajax({
       type:'POST',
       url:'kat.php',
       data:'save=1&katname='+$("#newInputKat").val(),
       success:function(){
        $("#buttonAddKat").removeAttr('disabled');
        location.reload();
       }
     });
   }
  }
  function deleteKat($id){
    if (confirm("Удалить ?")){
      $.ajax({
        type:'POST',
        url:'kat.php',
        data:'delete='+$id,
        success:function(){
          location.reload();
        }
      });
    }
  }
  function addRowsProvider(){
    $("#buttonAddProvider").attr('disabled', '');
    $("#tableProvider").find("tbody").prepend("<tr id='newRow'><td><input class='form-control form-control-sm' id='newInputProvider'/></td><td><a href='#' class='btn btn-warning btn-sm mr-1' onclick='javascript:saveRowsProvider();'>Сохранить</a><a href='#' class='btn btn-info btn-sm mr-1' onclick='javascript:deleteRowsProvider();'>Удалить</a></td></tr>");
  }
  function saveRowsProvider(){
   if ($("#newInputProvider")!=''){
     $.ajax({
       type:'POST',
       url:'provider.php',
       data:'save=1&providername='+$("#newInputProvider").val(),
       success:function(){
        $("#buttonAddProvider").removeAttr('disabled');
        location.reload();
       }
     });
   }
  }
  function deleteProvider($id){
    if (confirm("Удалить ?")){
      $.ajax({
        type:'POST',
        url:'provider.php',
        data:'delete='+$id,
        success:function(){
          location.reload();
        }
      });
    }
  }
