<?php
	session_start();

	require 'db.php';
	
	$sql = 'SELECT * FROM `users` WHERE `login` = :login';
	$query = $pdo->prepare($sql);
	$query->execute(['login' => $_POST['login']]);
	
	if ($_POST['log_out'] == 'Exit') $_SESSION['login'] = false;
	
if (!$query->rowCount()) {
    header('Location: /');
    die;
}

$login = $query->fetch(PDO::FETCH_ASSOC);

if (password_verify($_POST['password'], $login['password'])) {

    $_SESSION['login'] = true;
    header('Location: /');
    die;
}
header('Location: /');