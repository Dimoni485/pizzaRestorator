function loadrekvizit()
{
	$('a').css('background-color','');
	$('a:contains(Настройка)').css('background-color','#A2C2CE');
	$.ajax({
		url:'/setting/rekvizit.php',
		success: function (data){
		  $('.contenttab').html(data);
		}
	});
}
function loadprihod()
{
$('a').css('background-color','');
$('a:contains(Приход товара)').css('background-color','#A2C2CE');
$.ajax({
	url:'/prihod_sklad/prihodnew.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadanalitika()
{
$('a').css('background-color','');
$('a:contains(Аналитика)').css('background-color','#A2C2CE');
$.ajax({
	url:'/analitika/analitika.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function otchet()
{
$('a').css('background-color','');
$('a:contains(Отчеты)').css('background-color','#A2C2CE');
$.ajax({
	url:'/otcety/otceti.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadskidka()
{
$('a').css('background-color','');
$('a:contains(Скидки)').css('background-color','#A2C2CE');
$.ajax({
type:'GET',
	url:'/skidki/skidka.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadskidka_user()
{
$('a').css('background-color','');
$('a:contains(Индивидуальные скидки)').css('background-color','#A2C2CE');
$.ajax({
type:'GET',
	url:'/skidki/skidka_user.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadtovarpostavsik()
{
$('a').css('background-color','');
$('a:contains(Товар от поставщиков)').css('background-color','#A2C2CE');
$.ajax({
	url:'/postavsik/tovarpostavsik.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadprodukt()
{
$('a').css('background-color','');
$('a:contains(Номенклатура)').css('background-color','#A2C2CE');
$.ajax({
	type:'POST',
	url:'/produkciya/getprodukt.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadprodazi()
{
$('a').css('background-color','');
$('a:contains(Продажи)').css('background-color','#A2C2CE');
var datenow = new Date();
fd=datenow.getDate()+'.'+(datenow.getMonth()+1)+'.'+datenow.getFullYear();
$.ajax({
	type:'POST',
	url:'/prodazi/prodazi.php',
	data:'datastart='+fd,
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadsklad()
{
$('a').css('background-color','');
$('a:contains(Склад)').css('background-color','#A2C2CE');
$.ajax({
	url:'/sklad/sklad.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadspisanie()
{
$('a').css('background-color','');
$('a:contains(Списаные продукты)').css('background-color','#A2C2CE');
$.ajax({
	url:'/spisanie/spisanie.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadpostavsik()
{
$('a').css('background-color','');
$('a:contains(Поставщики)').css('background-color','#A2C2CE');
$.ajax({
	url:'/postavsik/postavsik.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function loadkat()
{
$('a').css('background-color','');
$('a:contains(Категории)').css('background-color','#A2C2CE');
$.ajax({
	url:'/kategorii/kat.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
});
};
function getsostav($idprod,$nacenka,$sebest){
    $.ajax({
        type: "POST",
        url: "/produkciya/getsostav.php",
        data: "naimenprodukt="+$idprod+"&sebest="+$sebest+"&nacenka="+$nacenka,
        success: function(html){
            $('.contenttab').empty();
            $('.contenttab').html(html);
        }
    });

}
/*Функция показа прокрутки*/
/*function show(state){
	document.getElementById('window').style.display = state;			
	document.getElementById('wrap').style.display = state; 			
	}*/

	jQuery( document ).ready(function() {
		jQuery('#scrollup img').mouseover( function(){
			jQuery( this ).animate({opacity: 0.65},100);
		}).mouseout( function(){
			jQuery( this ).animate({opacity: 1},100);
		}).click( function(){
			window.scroll(0 ,0); 
			return false;
		});

		jQuery(window).scroll(function(){
			if ( jQuery(document).scrollTop() > 0 ) {
				jQuery('#scrollup').fadeIn('fast');
			} else {
				jQuery('#scrollup').fadeOut('fast');
			}
		});
	});		