<div class="container">
	<div class="logo">
		<span class="icon"></span>
		<h1 class="header">To Do List</h1>
	</div>
	<div class="content">
		<div id="status">
			<form action="<?php echo ROOT_HTML; ?>task/<?php echo @$parameters['page']; ?>" method="POST">
				<div>
					<select name="sort" id="js-sort" class="select-sort">
						<option class="sel" value="name_up" <?php if(@$_POST['sort'] == 'name_up') echo 'selected'; ?>>Sort by ascending name</option>
						<option value="name_down" <?php if(@$_POST['sort'] == 'name_down') echo 'selected'; ?>>Sort by descending name</option>
						<option value="email_up" <?php if(@$_POST['sort'] == 'email_up') echo 'selected'; ?>>Sort by ascending email</option>
						<option value="email_down" <?php if(@$_POST['sort'] == 'email_down') echo 'selected'; ?>>Sort by descending email</option>
						<option value="status_up" <?php if(@$_POST['sort'] == 'status_up') echo 'selected'; ?>>Sort by ascending status</option>
						<option value="status_down" <?php if(@$_POST['sort'] == 'status_down') echo 'selected'; ?>>Sort by descending status</option>
					</select>
					<input type="submit" name="execute" value="Sorting" class="select-sort">
				</div>
			</form>
			<?php echo LoginController::actionExit(); ?>
		</div>
		<!-- Table -->
		<section>
			<a href="<?php echo ROOT_HTML; ?>task/add" class="add-link">+</a>
			<div class="table">
				<table>
					<tr class="header3">
						<th>Name</th>
						<th>Email</th>
						<th>Task</th>
						<th>Status</th>
						<?php if($_SESSION['login']) echo '<th></th>';?>
					</tr>
					<?php
						foreach($parameters['taskList'] as $row) {
							echo '<tr>';
								echo '<td class="text-left">'.$row['name'].'</td>';
								echo '<td>'.$row['email'].'</td>';
								echo '<td>'.$row['text'].'</td>';
								echo '<td>'.$row['status'].'</td>';
								if($_SESSION['login']) echo "<td><form method='post' action='".ROOT_HTML."edit/".$row['id']."' >
										<input type='submit' value='Edit' name='button_edit' class='button-edit'/>
										<input type='submit' value='Del ' name='button_del' class='button-edit'/>
									</form></td>";
							echo '</tr>';
						}
					?>
				</table>
			</div>
		</section>
		<br>
		<hr/>
		<!-- Pagination -->
		<section class="pagination pagination-small">  
			<div class="pagination-icons">
				<?php echo Pagination::linkPagination($parameters['page'], $parameters['pagesCount'], @$parameters['sort']); ?>
			</div>
		</section>
	</div>
</div>