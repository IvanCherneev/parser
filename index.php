<?php
include_once('model/startup.php');
include_once('controller/C_Glav.php');

// Инициализация
startup();

// Выбор контроллера
switch ($_GET['c'])
{
case 'glav':
	$controller = new C_Glav();
	break;
default:
	$controller = new C_Glav();
}

// Обработка запроса.
$controller->Request();
