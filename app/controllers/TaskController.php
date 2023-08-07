<?php
class TaskController
{
	// Список задач
	public function actionIndex($page = 1, $param = false) {

		if(!empty($param)) { //проверяем существование переменной
		
			Router::ErrorPage404('Лишний параметр в списке'); //------------------DEBUGGING
			die; //прекратить выполнение текущего скрипта
		}
		
		$sort_list = array( //массив для соотношения сортировки
			'name_up'       => '`name`',
			'name_down'       => '`name` DESC',
			'email_up'       => '`email`',
			'email_down'  => '`email` DESC',
			'status_up' => '`status`',   
			'status_down' => '`status` DESC',   
		);
		$sorting = 'name'; //столбец для сортировки
		
		$parameters = array();
		
		if(!empty($_POST['sort'])) { //если нажата кнопка сортировки
			if (array_key_exists($_POST['sort'], $sort_list)) {//Проверяем, есть ли в массиве указанный ключ
				$sorting = $sort_list[$_POST['sort']];
				$parameters['sort'] = $_POST['sort'];
			}
		}
		
		// Вычисляем количество страниц
		$pagesCount = ceil(Task::getCountList() / 3); //Округляем дробь в большую сторону
		if($pagesCount == 0) $pagesCount = 1;
		$parameters['pagesCount'] = $pagesCount;
		$parameters['page'] = $page;
		
		$page = ($page-1)*3; //вычисляем сколько записей пропускать
		
		$taskList = array();
		$taskList = Task::getTaskList(3, $sorting, $page); //обращение к статическому методу модели
		$parameters['taskList'] = $taskList;
		
		$templates = array(
			'task',
			'content',
			'footer'
		);
		
		LoadingPages::view($templates, $parameters);
	}

	// Просмотр и редактирования одной задачи
	public function actionView($id, $id2 = false) {
		
		if(!$_SESSION['login']) { //проверяем авторизован или нет пользователь
		
			Router::ErrorPage404('Нет авторизации'); //------------------DEBUGGING
			die; //прекратить выполнение текущего скрипта
		}
		
		if($id2) { //проверяем существование второй переменной
		
			Router::ErrorPage404('Лишний параметр в просмотре'); //------------------DEBUGGING
			die; //прекратить выполнение текущего скрипта
		}
		
		if($id) {
			
			$message = '';
			
			// Если пришли по нажатию кнопки удалить
			if(@$_POST['button_del'] == 'Del '){
					Task::deleteTask($id);
					header('Location: '.ROOT_HTML.'task');
			}
			
			// Если пришли по нажатию кнопки сохранить
			if(@$_POST['button_save'] == 'Save'){
				// Если все поля заполнены
				if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['task']) && !empty($_POST['status'])) {
					$task_array = array(
						'id' => $id,
						'name' => $_POST['name'],
						'email' => $_POST['email'],
						'task' => $_POST['task'],
						'status' => $_POST['status']
					);
					$message = Task::editTask($task_array);
				}else {
					$message = 'Fill in all the fields';
				}
			}
			
			$newsItem = Task::getTaskItemById($id);	//обращение к статическому методу модели
			
			if(!$newsItem) {
				header('Location: '.ROOT_HTML.'task');
			}
			
			$templates = array(
				'task',
				'edit',
				'footer'
			);
			$parameters = $newsItem;
			$parameters['message'] = $message;			
			LoadingPages::view($templates, $parameters);
		}
	}
	
	// Метод формы добавления записи в таблицу
	public function actionAdd() {
		
		$message = '';
		
		// Если пришли по нажатию кнопки добавить
		if(!empty($_POST['button-add']) &&  $_POST['button-add'] == 'Add') {
			// Если все поля заполнены
			if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['task'])) {
				// Если записей не больше 24
				if(Task::getCountList() < 25) {
					$task_array = array(
						'name' => $_POST['name'],
						'email' => $_POST['email'],
						'task' => $_POST['task']
					);
					$message = Task::addTask($task_array);
				}else {
					$message = 'Exceeded the limit';
				}
			}else {
				$message = 'Fill in all the fields';
			}
		}
		
		$templates = array(
			'task',
			'add',
			'footer'
		);
		$parameters = array(
			'message' => $message,
		);

		LoadingPages::view($templates, $parameters);
	}
}
?>