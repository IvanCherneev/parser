<?php

function startup()
{
	// Настройки подключения к БД
	$hostname = 'localhost'; 
	$username = 'root'; 
	$password = 'mysql';
	$dbName = 'parser';
	
	// Языковая настройка
	setlocale(LC_ALL, 'ru_RU.UTF-8');

	// Установка временной зоны
	date_default_timezone_set('UTC');
	
	// Подключение к БД
	mysql_connect($hostname, $username, $password) or die('No connect with data base'); 
	mysql_query('SET NAMES utf8');
	mysql_select_db($dbName) or die('No data base');

	// Открытие сессии
	session_start();		
}
