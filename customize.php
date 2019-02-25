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




input {
    margin: .4rem;
}

</style>


<div class="wrapper">

<?php
	include_once "sidebar.php";
?>

<div id="tree">
<div class="header" id="myHeader">
  <h4><i class="fas fa-cog"></i>&nbsp;&nbsp;To edit your account details, go to Account <u>over here</u>!</h4>
</div>

<div class="pt-box" style="    width: 574px;
    border-radius: 3px;
    margin: 20px 0px 0px 50px;    background: #fff0;box-shadow: 0 0px 0px rgba(0, 0, 0, 0.13);">


	<form class="pt-form" id="send-detail" style="background-color: #ffffffba;">

	<h4>Customize your Vegan tree!</h4><br>



<h5>Labels</h5>
<table>
<?php
		$sql = db_select(['table' => 'labels', 'where' => '(account_id IS NULL || account_id = ' . $_SESSION['login'] . ')']);
		while( $label = $sql->fetch_assoc() ) {
            $disabled = $label ?>
    <tr>
        <td><input type="text" name="label" placeholder="Label" value="<?=$label[ 'name' ]?>"></td>
        <td><input type="color" id="head" name="head" value="<?=$label[ 'color' ]?>" disabled></td>
        <td><i class="<?=$label[ 'icon' ]?> fa-fw"></i></td><?php } ?>
    </tr>
</table>
<br/>





		<div class="pt-input">
			<i class="icons icon-key"></i>

			<i class="icons icon-key"></i>
			<input type="password" name="pass" placeholder="Update your account password">
		</div>

		<div class="pt-input">

		<select name="public">
	<option value="public">Make my tree link public</option>
	<option value="private">Password protect my tree</option>
	</select>
	</div>

		<div class="pt-input">
			<i class="icons icon-list"></i>
			<input type="password" name="vpass" placeholder="Update your tree password">
		</div>
		<div class="pt-input">
			<i class="icons icon-envelope"></i>
			<input type="text" name="email" value="<?=db_get("accounts", "email", $lg)?>" placeholder="Update your email">
		</div>
		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> Update Account</button>

	</form>
</div>



</div>
</div>















<!-- Latest compiled and minified JavaScript -->
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>
