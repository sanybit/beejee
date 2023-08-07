<?php
class Task
{
	// Метод возвращает одну задачу по индификатору в запросе ($id)
	public static function getTaskItemById($id) {
		$id = intval($id); //возвращаем целое значение переменной
		if ($id){
			
			$db = Db::getConnection(); //получаем объект класса PDO из класса Db

			$result = $db->query('SELECT * FROM list WHERE id='.$id);

			$result->setFetchMode(PDO::FETCH_ASSOC); //оставит индексы ввиде названий

			$newsItem = $result->fetch();

			return $newsItem;
		}
	}

	// Метод возвращает список задач
	public static function getTaskList($count_rows = 1, $sorting = 'id', $page = 0) {

		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		$newsList = array();
		
		// Делаем запрос в запросе к базе чтобы отсортировать конечный результат
		// Делаем выборку для страници 3 записи и в ней сортируем по заданному полю
		$result = $db->query("SELECT * FROM (SELECT * FROM list ORDER BY id LIMIT $count_rows OFFSET $page) a ORDER BY $sorting");
		
		$result->setFetchMode(PDO::FETCH_ASSOC); //оставит индексы ввиде названий
		
		// В цикле обращаемся к методу fetch() объекта в переменной $result
		// при этом в цикле мы будем получать доступ к переменной $row,
		// которая символизирует строку из БД
		// (При работе с PDO - используется Объектно-Ориентированный Подход)
		// В цикле мы записываем необходимые полученные данные в массив результата
		// и далее, возвращаем этот массив: return $newsList
		$i = 0;
		while($row = $result->fetch()) {
			foreach($row as $name => $res) {
				$newsList[$i][$name] = $res;
			}
			$i++ ;
		}
		return $newsList ;
	}
	
	// Метод возвращает количество записей в таблице
	public static function getCountList() {

		$db = Db::getConnection(); //получаем объект класса PDO из класса Db

		// Описываем нужный запрос к базе данных
		$result = $db->query('SELECT COUNT(*) FROM `list`'); //получаем количество всех записей
		$count = $result->fetchColumn(); //получаем из объекта число
		
		return $count;
	}
	
	// Метод добавления записи в таблицу
	public static function addTask($task_array, $status = 'New task') {

		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		
		// Преобразуем специальные символы в HTML-сущности
		$name = htmlspecialchars($task_array['name']);
		$email = htmlspecialchars($task_array['email']);
		$task = htmlspecialchars($task_array['task']);
		
		// Описываем нужный запрос к базе данных
		$sql = "INSERT INTO list(name, email, text, status) VALUES(:name, :email, :text, :status)";
		
		// Подготавливаем SQL запрос (зашита от инъекций)
		$query = $db->prepare($sql);
		  
		// Выполняем запрос к базе
		if ($query->execute(['name' => $name, 'email' => $email, 'text' => $task, 'status' => $status])) {
			return 'Task successfully added';
		}else return 'The task could not be added';
	}
	
	// Метод изменения записи в таблице
	public static function editTask($task_array) {

		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		
		// Преобразуем специальные символы в HTML-сущности
		$id = htmlspecialchars($task_array['id']);
		$id = intval($id); //возвращаем целое значение переменной
		$name = htmlspecialchars($task_array['name']);
		$email = htmlspecialchars($task_array['email']);
		$task = htmlspecialchars($task_array['task']);
		$status = htmlspecialchars($task_array['status']);
		
		// Описываем нужный запрос к базе данных
		$sql = "UPDATE list SET name = :name, email = :email, text = :text, status = :status WHERE id=".$id;

		// Подготавливаем SQL запрос (зашита от инъекций)
		$query = $db->prepare($sql);
		  
		// Выполняем запрос к базе
		if ($query->execute(['name' => $name, 'email' => $email, 'text' => $task, 'status' => $status])) {
			return 'Changes saved';
		}else return 'Changes are not saved';
	}
	
	// Метод удаления записи в таблице
	public static function deleteTask($id) {

		$db = Db::getConnection(); //получаем объект класса PDO из класса Db
		
		// Преобразуем специальные символы в HTML-сущности
		$id = htmlspecialchars($id);
		$id = intval($id); //возвращаем целое значение переменной
		
		// Описываем нужный запрос к базе данных
		$sql = 'DELETE FROM `list` WHERE `id` = ?';

		// Подготавливаем SQL запрос (зашита от инъекций)
		$query = $db->prepare($sql);
		  
		// Выполняем запрос к базе
		if ($query->execute([$id])) {
			return 'Task deleted';
		}else return 'The task was not deleted';
	}
}
?>