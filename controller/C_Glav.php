<?php
include_once('controller/C_Base.php');
include_once('model/M_Function.php');
include_once('model/phpExcel/PHPExcel.php');

//
// Контроллер Главной страницы
//
class C_Glav extends C_Base 
{
	private $price;					// прайс-лист
	private $result_prov1;			// количество добавленных прайсов поставщика 1
	private $result_prov2;			// количество добавленных прайсов поставщика 2
	private $error_space_prov1;		// количество ошибок лишних пробелов поставщика 1
	private $error_space_prov2;		// количество ошибок лишних пробелов поставщика 2
	private $error_noprice_prov1;	// товар с отсутствующим ценником поставщика 1
	private $error_noprice_prov2;	// товар с отсутствующим ценником поставщика 2
	private $error_noart_prov1;		// товар с отсутствующим артикулом поставщика 1
	private $error_noart_prov2;		// товар с отсутствующим артикулом поставщика 2
	private $error_noprice_bd;		// проверка на наличие в БД всех ценников
	private $new_product_prov1;		// товар не присутствующий в БД поставщика 1
	private $new_product_prov2;		// товар не присутствующий в БД поставщика 2
	private $count_price_bd;		// количество товара в БД
	private $count_price_prov1;		// количество товаров в прайсе поставщика 1
	private $count_price_prov2;		// количество товаров в прайсе поставщика 2
	
	//
    // Конструктор
    //
    function __construct() 
    {
    	parent::__construct();
	}

    //
    // Виртуальный обработчик запроса
    //
    protected function OnInput() 
    {
		// C_Base
		parent::OnInput();
		$this->title = 'главная страница';
		$kurs = 30; // Установка курса в рублях
		
		// Менеджеры
		$mFunction = M_Function::Instance();
		$mProvider1 = PHPExcel_IOFactory::load('files/price1.xls');
		$mProvider2 = PHPExcel_IOFactory::load('files/price2.xlsx');
					
		// Добавление прайсов поставщиков на товары и вывод информации 
		// о колличестве успешно добавленных прайсов
		$this->result_prov1 = $mFunction->addPriceProv1($mProvider1);
		$this->result_prov2 = $mFunction->addPriceProv2($mProvider2, $kurs);
		
		// Проверка на ошибки в прайсах поставщиков (отсутствие цен на товары)
		$this->error_noprice_prov1 = $mFunction->checkPriceProv1($mProvider1);
		$this->error_noprice_prov2 = $mFunction->checkPriceProv2($mProvider2);
		
		// Проверка на прогрузку всех цен от поставщиков в нашу БД
		if ($mFunction->checkPriceBD()) {
			$this->error_noprice_bd = 'Да';
		} else {
			$this->error_noprice_bd = 'Нет';
		}
		
		// Проверка на ошибки в прайсах поставщиков (лишние пробелы в артикулах)
		$this->error_space_prov1 = $mFunction->checkPriceSpaceProv1($mProvider1);
		$this->error_space_prov2 = $mFunction->checkPriceSpaceProv2($mProvider2);
		
		// Проверка на ошибки в прайсах поставщиков (отсутствие артикулов на товары)
		$this->error_noart_prov1 = $mFunction->checkArtProv1($mProvider1);
		$this->error_noart_prov2 = $mFunction->checkArtProv2($mProvider2);
		
		// Проверка на наличие нового товара, которого нет в нашей БД
		$this->new_product_prov1 = $mFunction->checkNewProductProv1($mProvider1);
		$this->new_product_prov2 = $mFunction->checkNewProductProv2($mProvider2);
		
		// Получение общего количества элементов в БД и прайсах
		$this->count_price_bd = $mFunction->showCountPriceBD();
		$this->count_price_prov1 = $mFunction->showCountPriceProv1($mProvider1);
		$this->count_price_prov2 = $mFunction->showCountPriceProv2($mProvider2);
		
		// Получение общего прайса на товары
		$this->price = $mFunction->showPrice();
    }

    //
    // Виртуальный генератор HTML
    //
    protected function OnOutput() 
    {   	
	
        // Генерация содержимого Главной страницы
		$vars = array('title' => $this->title,
						'content' => $this->price,
						'result_prov1' => $this->result_prov1,
						'result_prov2' => $this->result_prov2,
						'error_space_prov2' => $this->error_space_prov2,
						'error_space_prov1' => $this->error_space_prov1,
						'error_noprice_prov1' => $this->error_noprice_prov1,
						'error_noprice_prov2' => $this->error_noprice_prov2,
						'error_noart_prov1' => $this->error_noart_prov1,
						'error_noart_prov2' => $this->error_noart_prov2,
						'error_noprice_bd' => $this->error_noprice_bd,
						'new_product_prov1' => $this->new_product_prov1,
						'new_product_prov2' => $this->new_product_prov2,
						'count_price_bd' => $this->count_price_bd,
						'count_price_prov1' => $this->count_price_prov1,
						'count_price_prov2' => $this->count_price_prov2);
		
    	$this->content = $this->View('V_Glav.php', $vars);

		// C_Base
        parent::OnOutput();
    }
}