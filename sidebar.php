<?php
  include_once __DIR__.'/configs/config.php';
 ?>
<div id="sidebar" style="background-color:#da6161;height: 100vh;">

  <div id="account" style="background-color: white;padding: 15px 35px 15px 30px;border-radius: 10px;margin-bottom: 18px;">
    <?php if($lg): ?>
      <span class="title" style="font-size:20px;">Welcome, <?php $sql = $db->query("SELECT * FROM ".prefix."accounts WHERE id = '{$id}'"); if($sql->num_rows){ $rs = $sql->fetch_assoc(); ?><?=$rs['name']?>!<?php } ?></span>
    <?php endif; ?>

    <?php if(!$lg): ?>
      <a class="title" style="">Welcome, Guest!</font>
    <?php endif; ?>

    <br>

    <?php if($lg): ?>
      <a href="/Test/account"><button class="button" style="margin-top: 15px;"><i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit account</button></a><br>
      <a href="/Test/customize"><button class="button"><i class="fas fa-cog"></i>&nbsp;&nbsp;Customization</button></a><br>
      <button class="button"><i class="fas fa-comments"></i>&nbsp;&nbsp;View requests <h7 style="float:right;">0</h2> </button><br>
      <button class="button"><i class="fas fa-bell"></i>&nbsp;&nbsp;Email settings</button><br>
      <a title="Logout"><button class="button logout" style="background-color: #da6161;"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Logout</button></a><br>
    <?php endif; ?>

    <?php if(!$lg): ?>


	<form class="pt-form" id="send-login" style="padding: 15px 0px 0px 0px;">
		<div class="pt-input">
			<i class="icons icon-user"></i>
			<input type="text" name="name" placeholder="Username">
		</div>
		<div class="pt-input">
			<i class="icons icon-key"></i>
			<input type="password" name="pass" placeholder="Password">
		</div>
		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> Sign In</button>
		<div class="pt-new"><a href="sign-up.php">Register!</a></div>
	</form>

    <?php endif; ?>
  </div>

  <div id="welcome" style="background-color: white;padding: 21px;border-radius: 10px;margin-bottom: 18px;">
    Welcome to <a href="https://myvegantree.org" style="color: #da6161;">MyVeganTree.org</a>! Track your Vegan impact by adding people that have gone Vegan, Vegetarian, or reduced their consumption because of your activism!
    <br><br>
    If someone on your tree makes their own account, add them by username and you'll see their live tree and stats automatically added to yours, easy peasy!
  </div>

  <div id="donate" style="background-color: white;padding: 21px;border-radius: 10px;margin-bottom: 18px;">
    <center>
      <a href="https://www.patreon.com/youaretheirvoice" target="_blank"><img src="/images/yatv-logo.png" style="width:70%;"></a>
      <br>
      <br>
      This site is an 100% ad-less and free project by <a href="https://youaretheirvoice.com/" target="_blank">YouAreTheirVoice.com</a>, which is funded by its Patreon supporters. Please <a href="https://www.patreon.com/youaretheirvoice" target="_blank">consider a donation</a> if you find our site useful! Thank you <i>so much!</i>
    </center>

  </div>

</div>
