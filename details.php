<?php
	include_once "header.php";
?>

<?php
	include_once "sidebar.php";
?>
<div class="pt-box">
	<h3>Details:</h3>

	<form class="pt-form" id="send-detail">
		<div class="pt-input">
			<i class="icons icon-user"></i>
			<input type="text" name="name" value="<?=db_get("families", "name", $lg)?>" placeholder="Write your family ID">
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
			<input type="text" name="email" value="<?=db_get("families", "email", $lg)?>" placeholder="Write your email">
		</div>
		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> Send Details</button>
		<div class="pt-new"><a href="tree.php?id=<?=$lg?>">Back!</a></div>
	</form>
</div>
<?php
	include_once "footer.php";
?>
