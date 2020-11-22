function loadrekvizit()
{
	$('a').css('background-color','');
	$('a:contains(Настройка)').css('background-color','#A2C2CE');
	document.getElementById('preloaderbg').style.display = 'block';
	    document.body.style.overflow = 'hidden';
	$.ajax({
		url:'rekvizit.php',
		success: function (data){
		  $('.contenttab').html(data);
	document.getElementById('preloaderbg').style.display = 'none';
	document.body.style.overflow = 'visible';
		}
	});
}
function loadprihod()
{
$('a').css('background-color','');
$('a:contains(Приход товара)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
	url:'prihodnew.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadanalitika()
{
$('a').css('background-color','');
$('a:contains(Аналитика)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
	url:'analitika.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function otchet()
{
$('a').css('background-color','');
$('a:contains(Отчеты)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
	url:'otceti.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadskidka()
{
$('a').css('background-color','');
$('a:contains(Скидки)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
type:'GET',
	url:'skidka.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadskidka_user()
{
$('a').css('background-color','');
$('a:contains(Индивидуальные скидки)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
type:'GET',
	url:'skidka_user.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadtovarpostavsik()
{
$('a').css('background-color','');
$('a:contains(Товар от поставщиков)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
	url:'tovarpostavsik.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadprodukt()
{
$('a').css('background-color','');
$('a:contains(Номенклатура)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	url:'getprodukt.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadprodazi()
{
$('a').css('background-color','');
$('a:contains(Продажи)').css('background-color','#A2C2CE');
var datenow = new Date();
fd=datenow.getDate()+'.'+(datenow.getMonth()+1)+'.'+datenow.getFullYear();

document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	type:'POST',
	url:'prodazi.php',
	data:'datastart='+fd,
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadsklad()
{
$('a').css('background-color','');
$('a:contains(Склад)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	url:'sklad.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadspisanie()
{
$('a').css('background-color','');
$('a:contains(Списание)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	url:'spisanie.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadpostavsik()
{
$('a').css('background-color','');
$('a:contains(Поставщики)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	url:'postavsik.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function loadkat()
{
$('a').css('background-color','');
$('a:contains(Категории)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	url:'kat.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
/*Функция показа прокрутки*/
function show(state){
	document.getElementById('window').style.display = state;			
	document.getElementById('wrap').style.display = state; 			
	}

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