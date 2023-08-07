<?php
class Login
{
	// Метод проверки логина и пароля
	public static function getLogin($name, $password) {

		$db = Db::getConnection(); //получаем объект класса PDO из класса Db

		// Описываем нужный запрос к базе данных
		$sql = 'SELECT * FROM `users` WHERE `login` = :login';
		
		// Подготавливаем SQL запрос (зашита от инъекций)
		$query = $db->prepare($sql);

		// Выполняем запрос к базе
		$query->execute(['login' => $name]);
		
		if($query->rowCount()) {
			$login = $query->fetch(PDO::FETCH_ASSOC);
			if(password_verify($password, $login['password'])) {
				return true;
			}
		}
		return false;
	}
}
?>