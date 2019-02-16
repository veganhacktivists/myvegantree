<?php
  include_once __DIR__.'/configs/config.php';
 ?>
<div id="sidebar" style="background-color:#da6161;height: 100vh;">

  <div id="account" style="background-color: white;padding: 15px 35px 15px 30px;border-radius: 10px;margin-bottom: 18px;">
    <?php if($lg): ?>
      <span class="title" style="font-size:20px;">Welcome, <?php $sql = $db->query("SELECT * FROM ".prefix."families WHERE id = '{$id}'"); if($sql->num_rows){ $rs = $sql->fetch_assoc(); ?><?=$rs['name']?>!<?php } ?></span>
    <?php endif; ?>

    <?php if(!$lg): ?>
      <a class="title" style="">Welcome, Guest!</font>
    <?php endif; ?>

    <br>

    <?php if($lg): ?>
      <a href="details.php"><button class="button" style="margin-top: 15px;"><i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit account</button></a><br>
      <button class="button"><i class="fas fa-cog"></i>&nbsp;&nbsp;Customization</button><br>
      <button class="button"><i class="fas fa-comments"></i>&nbsp;&nbsp;View requests <h7 style="float:right;">0</h2> </button><br>
      <button class="button"><i class="fas fa-bell"></i>&nbsp;&nbsp;Email settings</button><br>
      <a title="Logout"><button class="button" style="background-color: #da6161;"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Logout</button></a><br>
    <?php endif; ?>

    <?php if(!$lg): ?>
      <a href="details.php"><button class="button" style="margin-top: 15px;"><i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Login</button></a><br>
      <button class="button"><i class="fas fa-cog"></i>&nbsp;&nbsp;Register</button>
    <?php endif; ?>
  </div>

  <div id="welcome" style="background-color: white;padding: 21px;border-radius: 10px;margin-bottom: 18px;">
    Welcome to <a href="https://myvegantree.org" style="color: #da6161;">MyVeganTree.org</a>! Track your Vegan impact by adding people that have gone Vegan, Vegetarian, or reduced their consumption because of your activism!
    <br><br>
    If someone on your tree makes their own account, add them by username and you'll see their live tree and stats automatically added to yours, easy peasy!
  </div>

  <div id="donate" style="background-color: white;padding: 21px;border-radius: 10px;margin-bottom: 18px;">
    <center>
      <a href="https://www.patreon.com/youaretheirvoice" target="_blank"><img src="https://myvegantree.org/images/yatv-logo.png" style="width:70%;"></a>
      <br>
      <br>
      This site is an 100% ad-less and free project by <a href="https://youaretheirvoice.com/" target="_blank">YouAreTheirVoice.com</a>, which is funded by its Patreon supporters. Please <a href="https://www.patreon.com/youaretheirvoice" target="_blank">consider a donation</a> if you find our site useful! Thank you <i>so much!</i>
    </center>

  </div>

</div>
