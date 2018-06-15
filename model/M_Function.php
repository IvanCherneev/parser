<?php
include_once('model/MSQL.php');
//
// Помощник работы с БД
//
class M_Function
{
	private static $instance;	// экземпляр класса
	private $msql; 				// драйвер БД

	//
	// Получение экземпляра класса
	// результат	- экземпляр класса MSQL
	//
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new M_Function();
			
		return self::$instance;
	}
	
	//
	// Конструктор
	//
	public function __construct()
	{
		$this->msql = MSQL::Instance();
	}
	
	// Получить прайс
	public function showPrice(){
		
		// Запрос
		$query = "SELECT * 
				  FROM items_prices";
			
			return $this->msql->Select($query);
	}
	
	// Обновление цен провайдера 1
	public function addPriceProv1($excel) {
		
		// количество обработанных товаров из прайсов
		$countAllPriceAdd = 0;
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// Получение массива из базы данных
		$query = "SELECT *
				  FROM items_prices";
		$articles = $this->msql->Select($query);
		
		// перебираем полученый массив
		foreach ($articles as $ar_key => $ar_val) {
			foreach ($sheetColumns as $key => $val){
				if (trim($val[3]) == trim($ar_val['sku'])) {
					
					// Запрос
					$obj = array();
					$obj['price'] = $val[25];
					
					$t = "id = '%d'";
					$where = sprintf($t, $ar_val['id']);
					
					$countPriceAdd = $this->msql->Update('items_prices', $obj, $where);
					
					$countAllPriceAdd += $countPriceAdd;
				}
			} 
		}
		return $countAllPriceAdd;
	}

	// Обновление цен провайдера 2
	public function addPriceProv2($excel, $kurs) {
		
		// количество обработанных товаров из прайсов
		$countAllPriceAdd = 0;
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// Получение массива из базы данных
		$query = "SELECT *
				  FROM items_prices";
		$articles = $this->msql->Select($query);
		
		// перебираем полученый массив
		foreach ($articles as $ar_key => $ar_val) {
			foreach ($sheetColumns as $key => $val){
				if (trim($val[2]) == trim($ar_val['sku'])) {
					
					// Запрос
					$obj = array();
					$obj['price'] = $val[3] * $kurs;
					
					$t = "id = '%d'";
					$where = sprintf($t, $ar_val['id']);
					
					$countPriceAdd = $this->msql->Update('items_prices', $obj, $where);
					
					$countAllPriceAdd += $countPriceAdd;
				}	
			} 
		}
		return $countAllPriceAdd;
	}
	
	// Проверка прайса поставщика 2 на наличие лишних пробелов в артикулах
	public function checkPriceSpaceProv2($excel) {
		
		// Значение без пробелов
		$no_space;
		
		// Общее количество артикулов с лишними пробелами
		$count_ar_space = 0;
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// перебираем полученый массив
		foreach ($sheetColumns as $key => $val){
			$no_space = preg_replace('/^ +| +$|( ) +/m', '$1', $val[2]);
			if ($val[2] !== $no_space && $val[2] !== Null  && $key !== 8) {
				$count_ar_space += 1;
			}	
		}
		return $count_ar_space;
	}
	
	// Проверка прайса поставщика 1 на наличие лишних пробелов в артикулах
	public function checkPriceSpaceProv1($excel) {
		
		// Значение без пробелов
		$no_space;
		
		// Общее количество артикулов с лишними пробелами
		$count_ar_space = 0;
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// перебираем полученый массив
		foreach ($sheetColumns as $key => $val){
			$no_space = preg_replace('/^ +| +$|( ) +/m', '$1', $val[3]);
			if ($val[3] !== $no_space && $val[3] !== Null && $key !== 0) {
				$count_ar_space += 1;
			}	
		}
		return $count_ar_space;
	}
	
	// Проверка прайса поставщика 1 на отстутствие цен
	public function checkPriceProv1($excel) {
		
		// Массив товаров неимеющих цен
		$arr_noprice = array();
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// перебираем полученый массив
		foreach ($sheetColumns as $key => $val){
			if ($val[3] == true && $val[25] == Null) {
				$arr_noprice[] = $val[2];
			}
		}	
		return $arr_noprice;
	}
	
	// Проверка прайса поставщика 2 на отстутствие цен
	public function checkPriceProv2($excel) {
		
		// Массив товаров неимеющих цен
		$arr_noprice = array();
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// перебираем полученый массив
		foreach ($sheetColumns as $key => $val){
			if ($val[2] == true && $val[3] == Null) {
				$arr_noprice[] = $val[1];
			}
		}	
		return $arr_noprice;
	}
	
	// Проверка прайса поставщика 1 на наличие отстутствия артикулов
	public function checkArtProv1($excel) {
		
		// Массив товаров неимеющих артикулов
		$arr_noart = array();
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// перебираем полученый массив
		foreach ($sheetColumns as $key => $val){
			if ($val[2] == true && $val[3] == Null) {
				$arr_noart[] = $val[2];
			}
		}	
		return $arr_noart;
	}
	
	// Проверка прайса поставщика 2 на наличие отстутствия артикулов
	public function checkArtProv2($excel) {
		
		// Массив товаров неимеющих цен
		$arr_noart = array();
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// перебираем полученый массив
		foreach ($sheetColumns as $key => $val){
			if ($val[1] == true && $val[2] == Null) {
				$arr_noart[] = $val[1];
			}
		}
		array_shift($arr_noart); // Удаляем первый элемент массива, т.к. это заголовок файла
		return $arr_noart;
	}
	
	// Проверка на прогрузку всех цен в нашу БД от наших поставщиков
	public function checkPriceBD() {
		
		// Получение массива из базы данных
		$query = "SELECT *
				  FROM items_prices";
		$articles = $this->msql->Select($query);
		
		// перебираем полученый массив
		foreach ($articles as $ar_key => $ar_val) {
			if ($ar_val['price'] == 0 || $ar_val['price'] == "") {
				return false;
			}
		}
		return true;
	}
	
	// Проверка на наличие нового товара, которого нет в нашей БД у поставщика 1
	public function checkNewProductProv1($excel) {
		
		// массивы с наименованиями товаров из БД и прайса поставщика
		$arr_title_prov = array();
		$arr_title_bd = array();
		
		// массив для нового товара
		$new_product = array();
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// Получение массива из базы данных
		$query = "SELECT *
				  FROM items_prices";
		$articles = $this->msql->Select($query);
				
		// перебираем полученый масcив поставщика
		foreach ($sheetColumns as $key => $val) {
			if (trim($val[2]) !== '') {
				$arr_title_prov[] = trim($val[2]);
			}			
		}
		array_shift($arr_title_prov); // удаляем заголовок столбца с названиями товара
		
		// перебираем масcив нашей БД
		foreach ($articles as $ar_key => $ar_val) {
			$arr_title_bd[] = trim($ar_val['title']);
		}
		
		// Отбираем те элементы, которых не в нашей БД
		$new_product = array_diff(preg_replace('/^ +| +$|( ) +/m', '$1', $arr_title_prov), preg_replace('/^ +| +$|( ) +/m', '$1', $arr_title_bd));
		
		return $new_product;
	}
	
	// Проверка на наличие нового товара, которого нет в нашей БД у поставщика 2
	public function checkNewProductProv2($excel) {
		
		// массивы с наименованиями товаров из БД и прайса поставщика
		$arr_title_prov = array();
		$arr_title_bd = array();
		
		// массив для нового товара
		$new_product = array();
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// Получение массива из базы данных
		$query = "SELECT *
				  FROM items_prices";
		$articles = $this->msql->Select($query);
		
		// перебираем полученый масcив поставщика
		foreach ($sheetColumns as $key => $val) {
			if (trim($val[1]) !== '') {
				$arr_title_prov[] = trim($val[1]);
			}			
		}
		array_splice($arr_title_prov, 0, 2); // удаляем заголовок столбца с названиями товара	
		
		// перебираем масcив нашей БД
		foreach ($articles as $ar_key => $ar_val) {
			$arr_title_bd[] = trim($ar_val['title']);
		}
		
		// Отбираем те элементы, которых не в нашей БД
		$new_product = array_diff(preg_replace('/^ +| +$|( ) +/m', '$1', $arr_title_prov), preg_replace('/^ +| +$|( ) +/m', '$1', $arr_title_bd));
		
		return $new_product;
	}
	
	// Узнать количество элементов в БД
	public function showCountPriceBD() {
		
		// Получение массива из базы данных
		$query = "SELECT count(*)
				  FROM items_prices";
		return $this->msql->Select($query);
	}
	
	// Узнать количество товаров в прайсе поставщика 1
	public function showCountPriceProv1($excel) {
		
		// Массив содержащий количество позиций в прайсе поставщика
		$count_product_prov = array();
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// перебираем полученый масcив поставщика
		foreach ($sheetColumns as $key => $val) {
			if (trim($val[2]) !== '') {
				$count_product_prov[] = trim($val[2]);
			}			
		}
		array_shift($count_product_prov); // удаляем заголовок столбца с названиями товара
		
		return count($count_product_prov);	
	}
	
	// Узнать количество товаров в прайсе поставщика 2
	public function showCountPriceProv2($excel) {
		
		// Массив содержащий количество позиций в прайсе поставщика
		$count_product_prov = array();
		
		// Получение массива с прочитанного с Excel файла
        $sheetColumns = $excel->setActiveSheetIndex('0')->toArray();
		
		// перебираем полученый масcив поставщика
		foreach ($sheetColumns as $key => $val) {
			if (trim($val[1]) !== '') {
				$count_product_prov[] = trim($val[1]);
			}			
		}
		
		array_splice($count_product_prov, 0, 2); // удаляем заголовок столбца с названиями товара
		
		return count($count_product_prov);
	}
	
}