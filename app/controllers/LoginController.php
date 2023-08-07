<?php
class LoginController
{
	// Метод для формы входа
	public function actionEnter() {

		$message = '';
		
		// Если пришли по нажатию кнопки вход
		if(!empty($_POST['button-enter']) &&  $_POST['button-enter'] == 'Enter') {
			//Если все поля заполнены
			if(!empty($_POST['name']) && !empty($_POST['password'])) {
				
				// Преобразуем специальные символы в HTML-сущности
				$name = htmlspecialchars($_POST['name']);
				$password = htmlspecialchars($_POST['password']);
				
				if(Login::getLogin($name, $password)){ //если логин и пароль верны
					$_SESSION['login'] = true;
					header('Location: /task');
					die;
				}else $message = 'Не верные данные';
			}else $message = 'Поля обязательны для заполнения';
		}
		
		
		$templates = array(
			'login',
			'enter'
		);
		$parameters = array(
			'message' => $message
		);

		LoadingPages::view($templates, $parameters);
	}
	
	public static function actionExit() {
		
		$button = "<a href='".ROOT_HTML."enter'><div class='login-button'>Login</div></a>";
		
		if(!empty($_POST['log_out']) && $_POST['log_out'] == 'Exit') {
			$_SESSION['login'] = false;
			return $button;
		}
		
		if($_SESSION['login']) {
			$button = "<form method='post' action='".ROOT_HTML."task' >
					    <input type='submit' value='Exit' name='log_out' class='exit-button'/>
					  </form>";
		}
		return $button;
	}
}
?>