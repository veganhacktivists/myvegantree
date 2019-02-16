<?php
include "header.php";
?>
<div class="pt-box">
	<h3>Sign In:</h3>

	<form class="pt-form" id="send-login">
		<div class="pt-input">
			<i class="icons icon-user"></i>
			<input type="text" name="name" placeholder="Write your vegan ID">
		</div>
		<div class="pt-input">
			<i class="icons icon-key"></i>
			<input type="password" name="pass" placeholder="Write your password">
		</div>
		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> Sign In</button>
		<div class="pt-new"><a href="sign-up.php">Create a new vegan ID!</a></div>
	</form>
</div>
<?php
include "footer.php";
?>
