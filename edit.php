<?php 
if ($_POST['exit_to'] == 'exit') header('Location: index.php');
require 'db.php';
session_start();

if ($_SESSION['login']) {
	if ($_POST['save_to'] == 'save') {
		
		$id = htmlspecialchars($_POST['id']);
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$text = htmlspecialchars($_POST['text']);
		$status = htmlspecialchars($_POST['status']);
		
		$sql = "UPDATE list SET name= :name, email= :email, text= :text, status= :status  WHERE id= :id";
		$query = $pdo->prepare($sql);
		
		if ($query->execute(['name'=>$name, 'email'=>$email, 'text'=>$text, 'status'=>$status, 'id'=>$id])) header('Location: index.php?message=edit');
		else header('Location: index.php?message=error_set');
	}
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width" initial-scale=1>
	<link rel="stylesheet" href="style.css">
	<title>ToDo List</title>
	<link rel="icon" href="favicon.ico">
</head>
<body>
<?php
	if ($_SESSION['login']) {
		echo '<form method="post" action="login.php">
			  <input type="submit" value="Exit" name="log_out" />
		      </form>';
		if ($_GET['id']) {
			$id = $_GET['id'];
			$sql = 'SELECT * FROM `list` WHERE `id` = ?';
			$query = $pdo->prepare($sql);
			$query->execute([$id]);
			while($row = $query->fetch(PDO::FETCH_OBJ)) {
				$name = $row->name;
				$email = $row->email;
				$text = $row->text;
				$status = $row->status;
			}
			echo "<form action='edit.php' method='POST'>
					<input type='hidden' name='id' required value=$id>
					<input type='text' name='name' required value=$name>
					<input type='email' name='email' required value=$email>
					<input type='text' name='text' required value=$text>
					<select name='status' class='status'>
						<option value='1'";
			if($status==1)echo' selected=selected';
			echo ">new</option><option value='2'";
			if($status==2)echo'selected=selected';
			echo ">at work</option><option value='3'";
			if($status==3)echo'selected=selected';
			echo ">done</option><option value='4'";
			if($status==4)echo'selected=selected';
			echo ">archive</option>
					</select>
					<input type='submit' name='save_to' value='save'>
					<input type='submit' name='exit_to' value='exit'>
				</form>";
		} 
	}else {
		echo '<form method="post" action="login.php">
			  Login: <input type="text" name="login" />
			  password: <input type="password" name="password" />
			  <input type="submit" value="Войти" name="log_in" />
			  </form>';
	}
?>	
</body>
</html>