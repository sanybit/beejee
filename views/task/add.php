<div class="container">
	<div class="logo">
		<span class="icon"></span>
		<h1 class="header">ADD</h1>
	</div>
	<div class="content">
		<div id="status"><?php echo @$parameters['message']; ?></div>
		<section class="add">
			<form method="post" action="<?php echo ROOT_HTML; ?>task/add">
				<div class="box">
					<h1>Add task</h1>
					<input type="text" name="name" class="input-add" placeholder="Name" />
					<input type="email" name="email" class="input-add" placeholder="Email" />
					<input type="text" name="task" class="input-add" placeholder="Task" />
					<input type="submit" name="button-add" value="Add" class="button-add">
					<a href="<?php echo ROOT_HTML; ?>task" class="button-home">Home</a>
				</div>
			</form>
		</section>
	</div>
</div>
		