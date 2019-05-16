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
  <h4><i class="fas fa-user-tag"></i>&nbsp;&nbsp;Welcome to My Vegan Tree! Please register below...</h4>
</div>

<div class="pt-box" style="    width: 574px;
    border-radius: 3px;
    margin: 20px 0px 0px 50px;    background: #fff0;box-shadow: 0 0px 0px rgba(0, 0, 0, 0.13);">

	<form class="pt-form" id="send-user" style="background-color: #ffffffba;">


		<div class="pt-input">
			<i class="icons icon-user"></i>
			<input type="text" name="username" placeholder="Enter a username">
		</div>
		<div class="pt-input">
			<i class="icons icon-user"></i>
			<input type="text" name="name" placeholder="Enter your first name">
		</div>
        <div class="pt-input">
            <i class="icons icon-envelope"></i>
            <input type="text" name="email" placeholder="Enter your email address"></div>
		<div class="pt-input">
			<i class="icons icon-key"></i>
			<input type="password" id="pass1" name="pass" placeholder="Enter your password">
		</div>
		<div class="pt-input">
			<i class="icons icon-key"></i>
			<input type="password" id="pass2" placeholder="Confirm your password">
		</div>
		<p style="font-size: 15px;line-height: 16px;padding: 10px;"><i>Note: This next password is used for if you decide to make your tree private - but still want to share it with a select few people.</i></p>
        <select name="public" class="tree-select">
        <option value="1">Make my tree link public</option>
        <option value="2">Password protect my tree</option>
        </select>
		<div class="pt-input tree-pass" style="display: none;">
			<i class="icons icon-list"></i>
			<input type="password" name="vpass" placeholder="Enter your Tree password">
		</div>
		<br>
		<div class="pt-input">
		<input type="checkbox" class="form-check-input" name="newslettercheck">
		<label class="form-check-label" for="newslettercheck">Subscribe to our vegan newsletter!</label>
		</div>
		
		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> Sign Up</button>
		<br><br>
		<i>You'll get a welcome email after a successful registration! Be sure to check your Spam folder if you don't see it in your inbox!</i>
	</form>
</div>



</div>
</div>















<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>
