<?php
include "header.php";
?>
<div class="pt-box">
	<h3>Sign Up:</h3>

	<form class="pt-form" id="send-user">
		<div class="pt-input">
			<i class="icons icon-user"></i>
			<input type="text" name="name" placeholder="Write your family ID">
		</div>
		<div class="pt-input">
			<i class="icons icon-key"></i>
			<input type="password" name="pass" placeholder="Write your password">
		</div>
		<div class="pt-input">
			<i class="icons icon-list"></i>
			<input type="password" name="vpass" placeholder="Write your view password">
		</div>
		<div class="pt-input">
			<i class="icons icon-envelope"></i>
			<input type="text" name="email" placeholder="Write your email">
		</div>
		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> Sign Up</button>
		<div class="pt-new"><a href="index.php">Sign in!</a></div>
	</form>
</div>
<?php
include "footer.php";
?>
