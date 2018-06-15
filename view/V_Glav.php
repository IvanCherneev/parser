<?php/*
	Шаблон главной страницы
	===============
	$content
	$result_prov1
	$result_prov2
	$error_space_prov1
	$error_space_prov2
	$error_noprice_prov1
	$error_noprice_prov2
	$error_noart_prov1
	$error_noart_prov2
	$error_noprice_bd
	$new_product_prov1
	$new_product_prov2
	$count_price_bd
	$count_price_prov1
	$count_price_prov2
*/?>

<!-- Таблица содержащая прайс-лист из БД -->
<div class="left-sidebar">
	<table class="table">
		<caption class="table__caption">Прайс-лист</caption>
		<tr class="table__tr-title">
			<td class="table__td">Артикул</td>
			<td class="table__td">Название</td>
			<td class="table__td">Цена</td>
		</tr>
		 <? foreach ($content as $price): ?>
			<tr class="table__tr">
				<td class="table__td"><?=$price['sku'] ?></td>
				<td class="table__td"><?=$price['title'] ?></td>
				<td class="table__td"><?=$price['price'] ?></td>
			</tr>
		<? endforeach ?> 
	</table>
</div>

<!-- Дополнительная информация к прайс-листу -->
<div class="right-sidebar">
	<div class="info">
		<div class="info__title">Дополнительная информация:</div>
		<!-- Количество прайсов -->
		<div class="info__count">
			<div class="info__count-title">Общее количество обработанных прайсов:</div>
			<div class="info__count-help">
				(PS: подгружаются в том случае, когда происходит обновление данных в БД,
				x/y: x - число загруженных прайсов, y - общее количество в прайсе или БД)
			</div>	
			<ul class="info__count-list">
				<li class="info__count-item">
					Прайсы загруженные в БД: <b><?=$result_prov2 + $result_prov1 ?></b>/<b><?=$count_price_bd[0]['count(*)'] ?></b>
				</li>
				<li class="info__count-item">
					Прайсы загруженные в БД от поставщика 1: <b><?=$result_prov1 ?></b>/<b><?=$count_price_prov1 ?></b>
				</li>
				<li class="info__count-item">
					Прайсы загруженные в БД от поставщица 2: <b><?=$result_prov2 ?></b>/<b><?=$count_price_prov2 ?></b>
				</li>
			</ul>
			<div class="info__count-result">Итог: Все ли прайсы загрузились в БД?: <b><?=$error_noprice_bd ?></b></div>
		</div>
		<!-- Причины повлиявшие на не загрузившиеся прайсы в БД -->
		<div class="info__causes">
			<div class="info__causes-title">Возможные причины:</div>
			<!-- Причина лишних пробелов -->
			<div class="info__causes-spaces">
				<div class="info__causes-subtitle">Лишние пробелы в артикулах:</div>
				<div class="info__causes-help">
					(PS: вероятность есть, но маленькая, так как перед загрузкой
					лишние начальные и конечные пробелы удалялись с помощью функции trim(),
					лишние пробелы между словами не учитывались)
				</div>
				<ul class="info__causes-list">
					<li class="info__causes-item">
						Количество лишний пробелов в артикулах у поставщика 1: <b><?=$error_space_prov1 ?></b>
					</li>
					<li class="info__causes-item">
						Количество лишний пробелов в артикулах у поставщица 2: <b><?=$error_space_prov2 ?></b>
					</li>
				</ul>
			</div>
			<!-- Причина отсутствия цен в прайсах -->
			<div class="info__causes-prices">
				<div class="info__causes-subtitle">Отсутствие цен в прайсе поставщиков:</div>
				<ul class="info__causes-list">
					<li class="info__causes-item">
						Товары не имеющие цен у поставщика 1:
						<ul>
							<? if (empty($error_noprice_prov1)): ?>
								<li>Все цены на товары присутствуют</li>
							<? else: ?>	
								<? foreach ($error_noprice_prov1 as $noprice => $value): ?>
										<li><?=$value ?></li>
								<? endforeach ?>
							<? endif ?>
						</ul>
					</li>
					<li class="info__causes-item">
						Товары не имеющие цен у поставщика 2:
						<ul>
							<? if (empty($error_noprice_prov2)): ?>
								<li>Все цены на товары присутствуют</li>
							<? else: ?>
								<? foreach ($error_noprice_prov2 as $noprice => $value): ?>
									<li><?=$value ?></li>
								<? endforeach ?>
							<? endif ?>
						</ul>
					</li>
				</ul>
			</div>
			<!-- Причина отсутствия артикулов в прайсах -->
			<div class="info__causes-code">
				<div class="info__causes-subtitle">Отсутствие артикулов в прайсе поставщиков:</div>
				<ul class="info__causes-list">
					<li class="info__causes-item">
						Товары не имеющие артикул у поставщика 1:
						<ul>
							<? if (empty($error_noart_prov1)): ?>
								<li>Все артикулы на товары присутствуют</li>
							<? else: ?>	
								<? foreach ($error_noart_prov1 as $noart => $value): ?>
										<li><?=$value ?></li>
								<? endforeach ?>
							<? endif ?>
						</ul>
					</li>
					<li class="info__causes-item">
						Товары не имеющие артикул у поставщика 2:
						<ul>
							<? if (empty($error_noart_prov2)): ?>
								<li>Все артикулы на товары присутствуют</li>
							<? else: ?>
								<? foreach ($error_noart_prov2 as $noart => $value): ?>
									<li><?=$value ?></li>
								<? endforeach ?>
							<? endif ?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- Результат проверки наличия нового товара в прайсах поставщиков -->
		<div class="info__news">
			<div class="info__news-title">Наличие новых товаров в прайсах от поставщиков, которых нет в БД:</div>
			<ul class="info__news-list">
				<li class="info__news-item">
					Новые товары поставщика 1:
					<ul>
						<? if (empty($new_product_prov1)): ?>
							<li>Новых товаров нет</li>
						<? else: ?>	
							<? foreach ($new_product_prov1 as $new_product => $value): ?>
									<li><?=$value ?></li>
							<? endforeach ?>
						<? endif ?>
					</ul>
				</li>
				<li class="info__news-item">
					Новые товары поставщика 2:
					<ul>
						<? if (empty($new_product_prov2)): ?>
							<li>Новых товаров нет</li>
						<? else: ?>	
							<? foreach ($new_product_prov2 as $new_product => $value): ?>
									<li><?=$value ?></li>
							<? endforeach ?>
						<? endif ?>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
