<?php
include_once('controller/C_Controller.php');
//
// Базовый контроллер сайта
//
abstract class C_Base extends C_Controller
{	
	protected $title;		// заголовок страницы
	protected $content;		// содержимое страницы

	//
	// Конструктор
	//
	function __construct()
	{
	}
	
	//
	// Виртуальный обработчик запроса
	//
	protected function OnInput()
	{
		
		// по умолчанию
		$this->title = 'Главная страница';
		$this->content = '';
		
	}
	
	//
	// Виртуальный генератор HTML
	//	
	protected function OnOutput()
	{
	    // Основной шаблон всех страниц
		$vars = array('title' => $this->title,
						'content' => $this->content);
						
		$page = $this->View('V_Basic.php', $vars);
        
		// Вывод HTML
        echo $page;
	}
}
