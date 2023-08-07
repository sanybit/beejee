	<form method="post" action="<?php echo ROOT_HTML; ?>enter">
		<h2><?php echo @$parameters['message']; ?></h2>
		<div class="box">
			<h1>Enter</h1>
			<input type="text" name="name" placeholder="Name" class="input-enter" />
			<input type="password" name="password" placeholder="Password" class="input-enter" />
			<input type="submit" name="button-enter" value="Enter" class="btn">
			<a href="<?php echo ROOT_HTML; ?>task" class="button-home">Home</a>
		</div>
	</form>
</body>
</html>