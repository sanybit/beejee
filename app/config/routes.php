<?php
// Маршруты
return array (
	'^$' => 'task/index', // пустая строка
	'task/enter' => 'login/enter',
	'task/add' => 'task/add',
	'task/([0-9]+)' => 'task/index/$1',
	'edit/([0-9]+)' => 'task/view/$1',
	'task' => 'task/index',
	'enter' => 'login/enter',
	'(.*)' => '404', // любая строка
);
// 'task' - строка запроса
// 'task/index' - имя контроллера и экшена для обработки этого запроса (путь обработчика)
?>