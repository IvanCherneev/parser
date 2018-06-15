<?php
//
// Базовый класс контроллера
//
abstract class C_Controller
{
	//
	// Конструктор
	//
	function __construct()
	{		
	}
	
	//
	// Полная обработка HTTP запроса
	//
	public function Request()
	{
		$this->OnInput();
		$this->OnOutput();
	}
	
	//
	// Виртуальный обработчик запроса
	//
	protected function OnInput()
	{
	}
	
	//
	// Виртуальный генератор HTML
	//	
	protected function OnOutput()
	{
	}
	
	//
	// Запрос произведен методом GET?
	//
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	//
	// Запрос произведен методом POST?
	//
	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	//
	// Генерация HTML шаблона в строку
	//
	protected function View($fileName, $vars = array())
	{
		// Установка переменных для шаблона
		foreach ($vars as $k => $v) 
		$$k = $v;
		// Генерация HTML в строку
		ob_start(); 
		include "view/$fileName"; 
		return ob_get_clean(); 	
	}	
}
