<?php/*
	Основной шаблон
	===============
	$title
	$content
*/?>
<!DOCTYPE html>
<html lang="ru-RU">
	<head>
		<title><?=$title?></title>
		<meta charset="UTF-8">
		<link href="style.css" rel="stylesheet" /> 
	</head>
	<body>
		<div class="content"><?=$content?></div>
		<div id="hellopreloader">
			<div id="hellopreloader_preload"></div>
		</div>
		<style type="text/css">
			#hellopreloader_preload {
				display: block;
				position: fixed;
				z-index: 99999;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				min-width: 1000px;
				background: #59ABE3 url(http://hello-site.ru//main/images/preloads/spinning-circles.svg) center center no-repeat;
				background-size:123px;
			}
		</style>
		<script type="text/javascript">
			var hellopreloader = document.getElementById("hellopreloader_preload");
			function fadeOutnojquery(el) {
				el.style.opacity = 1;
				var interhellopreloader = setInterval(function() {
					el.style.opacity = el.style.opacity - 0.05;
					if (el.style.opacity <=0.05) {
						clearInterval(interhellopreloader);
						hellopreloader.style.display = "none";
					}
				},16);
			}
			window.onload = function() {
				setTimeout(function() {
					fadeOutnojquery(hellopreloader);
				},500);
			};
		</script>-->
	</body>
</html>
