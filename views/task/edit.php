<div class="container">
	<div class="logo">
		<span class="icon"></span>
		<h1 class="header">To Do List</h1>
	</div>
	<div class="content">
		<div id="status">
			<div><?php echo $parameters['message'] ?></div>
			<?php echo LoginController::actionExit(); ?>
		</div>
		<!-- Table -->
		<section>
			<a href="<?php echo ROOT_HTML; ?>task" class="add-link">&#8617;</a>
			<form method='post' action="<?php echo ROOT_HTML.'edit/'.intval(@$parameters['id']); ?>" >
				<div class="table">
					<table>
						<tr class="header3">
							<th>Name</th>
							<th>Email</th>
							<th>Task</th>
							<th>Status</th>
							<th></th>
						</tr>
						<?php
							echo '<tr>';
								echo "<td><input type='text' name='name' class='input-edit' value='".@$parameters['name']."'/></td>";
								echo "<td><input type='email' name='email' class='input-edit' value='".@$parameters['email']."'/></td>";
								echo "<td><input type='text' name='task' class='input-edit' value='".@$parameters['text']."'/></td>";								
								echo "<td><select name='status' class='input-edit'>
										<option value='New task' ";
								if(@$parameters['status'] == 'New task') echo "selected='selected'";
								echo ">New task</option>
										<option value='In progress' ";
								if(@$parameters['status'] == 'In progress') echo "selected='selected'";
								echo ">In progress</option>
										<option value='To delete' ";
								if(@$parameters['status'] == 'To delete') echo "selected='selected'";
								echo ">To delete</option>
										<option value='Done' ";
								if(@$parameters['status'] == 'Done') echo "selected='selected'";
								echo ">Done</option></select></td>";
								echo "<td><input type='submit' value='Save' name='button_save' class='button-edit'/></td>";
							echo '</tr>';
						?>
					</table>
				</div>
			</form>
		</section>
		<br>
	</div>
</div>