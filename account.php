<?php
include_once "header.php";

$rt = true;
if(!$lg && !$vp){
	$rt = false;
}
if($lg && $lg != $id){
	$rt = false;
}
if($vp && $vp != $id){
	$rt = false;
}
?>

<style>
.wrapper {
  border : 0px dotted #ccc; padding: 0px;
}


#sidebar {  }
#tree { background-color: white;

    background-size: cover;
    background-image: url(https://i.imgur.com/dEqI5GG.png);
	    height: 100vh;
		}

@media screen and (min-width: 600px) {
   .wrapper {
      height: auto; overflow: hidden; // clearing
   }
   #sidebar { padding: 20px;width: 400px; float: left;height: 100vh; }
   #tree { margin-left: 400px; }
}


.input-color {
    position: relative;
}

.input-color input {
    padding-left: 20px;
    margin-bottom: 10px;
}

.input-color .color-box {
    width: 30px;
    height: 30px;
    background-color: #ccc;
    left: 5px;
    top: 5px;

}



.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  width: 100%;
  padding: 8px 14px;
  text-align: left;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}









</style>
<style>
.top-container {
  background-color: #f1f1f1;
  padding: 30px;
  text-align: center;
}

.header {
  padding: 10px 16px;
  background: #f95318;
  color: #fff;
}

.content {
  padding: 16px;
}

.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky + .content {
  padding-top: 102px;
}
</style>


<div class="wrapper">

<?php
	include_once "sidebar.php";
?>

<div id="tree">
<div class="header" id="myHeader">
  <h4><i class="fas fa-cog"></i>&nbsp;&nbsp;To customize your tree, go to Customization <u><a href="https://myvegantree.org/customize" style="color: #ffffff;">over here</a></u>!</h4>
</div>

<div class="pt-box" style="width: 574px;border-radius: 3px;margin: 20px 0px 0px 50px;background: #fff0;box-shadow: 0 0px 0px rgba(0, 0, 0, 0.13);">


	<form class="pt-form" id="send-detail" style="background-color: #ffffffba;">

	<h4><b>Updating your account</b></h4><br>

			 <p>You can update your account details here. If you've sent out tree requests that have been accepted, you will no longer be able to edit your username. Editing your username also changes your public/private tree link when you share it, your old link will break!</p>
<br>

	<h4><b>Update your Account Details</b></h4><br>
		<div class="pt-input">
			<i class="icons icon-user"></i>
			<input type="text" name="username" value="<?=db_get("accounts", "username", $lg)?>" placeholder="Update your Username">
		</div>
		<div class="pt-input">
			<i class="icons icon-user"></i>
			<input type="text" name="name" value="<?=db_get("accounts", "name", $lg)?>" placeholder="Update your Name">
		</div>
		<div class="pt-input">
			<i class="icons icon-key"></i>
			<input type="password" name="pass" placeholder="Update your account password">
		</div>
				<div class="pt-input">
			<i class="icons icon-envelope"></i>
			<input type="text" name="email" value="<?=db_get("accounts", "email", $lg)?>" placeholder="Update your email">
		</div>
		<hr>

		<div class="pt-input">

		<select name="public" class="tree-select">
		
		<?php 
		
		$grabcurrentvalue = db_get("accounts", "public", $lg);
		
		if ($grabcurrentvalue == 1) {
	    
		echo '<option value="1" selected="selected">Make my tree link public</option>';
		echo '<option value="2">Password protect my tree</option>';
		
		} else if ($grabcurrentvalue == 2) {
	    
		echo '<option value="1">Make my tree link public</option>';
		echo '<option value="2" selected="selected">Password protect my tree</option>';
		
		} else {
			
		echo '<option value="1" selected="selected">Make my tree link public</option>';
		echo '<option value="2">Password protect my tree</option>';
		
		}
		
		?>
		
		</select>
		

		</div>

		<div class="pt-input tree-pass"<?php if($grabcurrentvalue) echo ' style="display: none;"'; ?>>
			<i class="icons icon-list"></i>
            <input type="password" name="vpass" placeholder="Update your tree password" />
		</div>
	<p style="font-size: 13px;line-height: 16px;padding: 10px;">Note: If you password protect your tree, users you've given access to attach your tree will still be able to see your tree regardless!</p>

		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> Update Account</button>

	</form>
</div>



</div>
</div>















<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>
