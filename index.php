<?php 
session_start();
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
	}else {
		echo '<form method="post" action="login.php">
			  Login: <input type="text" name="login" />
			  password: <input type="password" name="password" />
			  <input type="submit" value="Войти" name="log_in" />
			  </form>';
	}
?>
	<form action="add.php" method="POST">
		<input type="text" name="name" required>
		<input type="email" name="email" required>
		<input type="text" name="text" required>
		<input type="submit" name="add" value="Add">
	</form>
	<form action="index.php" method="POST">
	<div class="select-sort">
		<select name="sort" id="js-sort">
			<option value="name_up" <?php if (@$_POST['sort'] == 'name_up') echo 'selected'; ?>>name_up</option>
			<option value="name_down" <?php if (@$_POST['sort'] == 'name_down') echo 'selected'; ?>>name_down</option>
			<option value="email_up" <?php if (@$_POST['sort'] == 'email_up') echo 'selected'; ?>>email_up</option>
			<option value="email_down" <?php if (@$_POST['sort'] == 'email_down') echo 'selected'; ?>>email_down</option>
			<option value="status_up" <?php if (@$_POST['sort'] == 'status_up') echo 'selected'; ?>>status_up</option>
			<option value="status_down" <?php if (@$_POST['sort'] == 'status_down') echo 'selected'; ?>>status_down</option>
		</select>
		<input type="submit" name="execute" value="sort_to">
	 </div>
	 </form>
	<ul>
		<?php
			require 'db.php';
			
			$sort_list = array(
				'name_up'       => '`name`',
				'name_down'       => '`name` DESC',
				'email_up'       => '`email`',
				'email_down'  => '`email` DESC',
				'status_up' => '`status`',   
				'status_down' => '`status` DESC',   
			);
			$sort = @$_POST['sort'];
			if (array_key_exists($sort, $sort_list)) {
				$sort_sql = $sort_list[$sort];
			} else {
				$sort_sql = reset($sort_list);
			}
			
			$query_count = $pdo->query('SELECT COUNT(*) FROM `list`');
			$pagesCount = ceil($query_count->fetchColumn() / 3);
			if ($_GET['page']) $page = ($_GET['page']-1)*3;
			else $page = 0;
			
			$query = $pdo->query("SELECT * FROM `list` ORDER BY $sort_sql LIMIT 3 OFFSET $page");

			if ($_GET['message'] != '') echo "</h3>".htmlspecialchars($_GET['message'])."</h3>";
			
			echo '<div>
				<li style="background: #aaa"><span class="name">Имя</span><span class="name">Email</span><span class="text">Текст задачи</span></li>
			</div>';
			
			while($row = $query->fetch(PDO::FETCH_OBJ)) {
				if ($row->status == 1) {
					echo '<div><li><span class="name">'. $row->name.'</span><span class="name">'.$row->email.'</span><span class="text">'.$row->text."</span>";
					if ($_SESSION['login']) echo "<a class='button' href='delete.php?id=".$row->id."'>X</a>";
					if ($_SESSION['login']) echo "<a class='button' href='edit.php?id=".$row->id."'>E</a>";
					echo '</li></div>';
				}
				if ($row->status == 2) {
					echo '<div><li><span class="name">'. $row->name.'</span><span class="name">'.$row->email.'</span><span class="text" style="background: #00f;">'.$row->text."</span>";
					if ($_SESSION['login']) echo "<a class='button' href='delete.php?id=".$row->id."'>X</a>";
					if ($_SESSION['login']) echo "<a class='button' href='edit.php?id=".$row->id."'>E</a>";
					echo '</li></div>';
				}
				if ($row->status == 3) {
					echo '<div><li><span class="name">'. $row->name.'</span><span class="name">'.$row->email.'</span><span class="text" style="background: #0f0;">'.$row->text."</span>";
					if ($_SESSION['login']) echo "<a class='button' href='delete.php?id=".$row->id."'>X</a>";
					if ($_SESSION['login']) echo "<a class='button' href='edit.php?id=".$row->id."'>E</a>";
					echo '</li></div>';
				}
				if ($row->status == 4) {
					echo '<div><li><span class="name">'. $row->name.'</span><span class="name">'.$row->email.'</span><span class="text" style="background: #f00;">'.$row->text."</span>";
					if ($_SESSION['login']) echo "<a class='button' href='delete.php?id=".$row->id."'>X</a>";
					if ($_SESSION['login']) echo "<a class='button' href='edit.php?id=".$row->id."'>E</a>";
					echo '</li></div>';
				}
			}
		?>
	</ul>
	<div class="pagination">
	<?php for ($pageNum = 1; $pageNum <= $pagesCount; $pageNum++) {
		echo "<a class='pages' href=index.php?page=$pageNum";
		if ($_GET['page'] == $pageNum)echo " style='background: #aaf'";
		if (!$_GET['page']&& $pageNum == 1)echo " style='background: #aaf'";
		echo ">$pageNum</a>";
	}?>
	</div>
</body>
</html>