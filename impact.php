<?php
$LOGIN_REQ_OVERRIDE = true;
include_once "header.php";
include __DIR__.'/configs/func.tree.php';

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

		 
// Let's grab from database to see if tree is private or public

$servername = "localhost";
$username = "vrdntf_nosrick";
$password = "imvegan";
$dbname = "vrdntf_myvegantree";
$conn = mysqli_connect($servername, $username, $password, $dbname);
$sql = "SELECT public FROM mvt_accounts WHERE username = '{$grab_username}'";
$result = mysqli_query($conn, $sql);
$check_if_tree_public = mysqli_fetch_row($result);


	// let's count all direct impacts, including attached accounts
	$cid_sql = "SELECT id FROM mvt_bubbles WHERE account_id = '{$id}'";
	$cid_result = mysqli_query($conn, $cid_sql);
	$grab_the_cid = mysqli_fetch_row($cid_result);
	$cid = $grab_the_cid[0];
	
	$sql_count_direct_impacts = "
        SELECT COUNT(*)
          FROM ".prefix."bubbles b
     LEFT JOIN ".prefix."requests r ON (b.account_id=r.to_id AND r.accepted=1)
         WHERE (parent = '{$cid}' OR r.from_id = '{$id}')
           AND type != 2
         ORDER BY r.accepted, b.date ASC";
		 
	$result_count_direct_impacts = mysqli_query($conn, $sql_count_direct_impacts);
	$count_direct_impacts = mysqli_fetch_row($result_count_direct_impacts);

	
if ($lg == $id || $id == $vp) {
	
	// never lock the tree if you're logged in on your own tree
	
} else {
	
if($check_if_tree_public[0] == 2) {

echo '<div class="pt-box">
	<h3 style="padding: 21px 0px 14px 0px;font-size: 24px;">This tree has been set to private!</h3>

	<form class="pt-form" id="send-vpass">
		<div class="pt-input">
			<i class="icons icon-list"></i>
			<input type="password" name="vpass" placeholder="Submit tree password">
		</div>
		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> View tree</button>
		<input type="hidden" name="id" value="'. $id . '" />
	</form>
</div>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>';

exit;
}
}
?>



<div class="wrapper" style="background-size: cover; background-image: url(https://i.imgur.com/dEqI5GG.png);">

<?php
	include_once "sidebar.php";
 ?>

<div id="tree">

<?php

// lets count how many times a bubble appears under a label
// will need to edit status = variable when we get custom statuses

$label_1 = $db->query("SELECT COUNT(*) FROM mvt_bubbles WHERE status = 'Vegan' && family = '{$id}'")->fetch_array();
$label_2 = $db->query("SELECT COUNT(*) FROM mvt_bubbles WHERE status = 'Vegetarian' && family = '{$id}'")->fetch_array();
$label_3 = $db->query("SELECT COUNT(*) FROM mvt_bubbles WHERE status = 'Plant-Based' && family = '{$id}'")->fetch_array();
$label_4 = $db->query("SELECT COUNT(*) FROM mvt_bubbles WHERE status = 'Getting there' && family = '{$id}'")->fetch_array();

?>

<div id="color-key">
<div class="input-color" style="background-color: #ffffff;padding: 10px;margin: 15px;width: 230px;border: 1px solid #EEE;border-radius: 10px;">
<a href="customize" style="float:right;color: #da6161;"><i>edit</i></a>
<table style="margin: 5px;">
  <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #06bf01;color:#fff;"><i class="fas fa-leaf fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Vegan (<?php echo $label_1[0];?>)</td>
  </tr>
  <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #8677e0;color:#fff;"><i class="fab fa-pagelines fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Vegetarian (<?php echo $label_2[0];?>)</td>
  </tr>
    <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #4fc9d4;color:#fff;"><i class="fab fa-envira fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Plant-Based (<?php echo $label_3[0];?>)</td>
  </tr>
      <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px; background-color: #da6161;color:#fff;"><i class="fas fa-route fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Getting there (<?php echo $label_4[0];?>)</td>
  </tr>
</table>

</div>

<div class="input-color" style="background-color: #ffffff;padding: 10px;margin: 15px;width: 230px;border: 1px solid #EEE;border-radius: 10px;">
<table style="width: 100%;margin: 5px;">
 <tr>
    <td><i class="fas fa-star"></i>&nbsp;&nbsp;Directly impacted:&nbsp;&nbsp;</div></td>
    <td style="text-align:left;"><b><?php echo $count_direct_impacts[0];?></b></td>
  </tr>
   <tr>
    <td><i class="fas fa-star-half-alt"></i>&nbsp;&nbsp;Indirectly impacted:&nbsp;&nbsp;</div></td>
    <td style="text-align:left;"><b id="indirectly-impacted-count">23</b></td>
  </tr>
</table>
</div>
</div>



<?php

  $sql = $db->query("SELECT * FROM ".prefix."accounts WHERE username = '{$grab_username}'");
  if($sql->num_rows){ $rs = $sql->fetch_assoc(); ?>
	<div class="tree">
    <div class="tree-inner">
    <?php if(db_count("bubbles WHERE family = '{$rs['id']}'")): ?>
      <ul>
        <?php
          $sql_m = $db->query("SELECT * FROM ".prefix."bubbles WHERE family = '{$rs['id']}' && parent = 0 ORDER BY date ASC");
          while($rs_m = $sql_m->fetch_assoc()){
            echo get_child($rs_m['id'], 0);
          }
        ?>
      </ul>
    <?php endif; ?>
    </div>
	</div>
	<?php } ?>
</div>

</div>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">


	<form id="send-details">

	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Add New member</h4>
	</div>

	<div class="modal-body">
	<div class="pt-form pt-forms">
	<div class="tab-content">

	<div class="row">
	<div class="col-md-6">
	<label>
	<input type="text" value="" placeholder="Enter name" name="name" />
	</label>
	</div>
	</div>

	<label>
	<select name="status">
	<option value="Vegan">Vegan</option>
	<option value="Vegetarian">Vegetarian</option>
	<option value="Plant-Based">Plant-Based</option>
	<option value="Getting there">Getting there</option>
	</select>
	</label>

	<label class="pt-birth">
	<input type="text" value="" placeholder="DD" name="birthday" />
	<input type="text" value="" placeholder="MM" name="birthmonth" />
	<input type="text" value="" placeholder="YYYY" name="birthyear" />
	</label>
	<label>
	<textarea name="bio" placeholder="Enter a personal note"></textarea>
	</label>

	<label>
	<input type="text" style="display:none;" value="" placeholder="Enter Photo URL" name="photo" />
	</label>
	<div class="prt-group">
	<input type="file" name="poll_file" id="file" class="inputfile" />
	<label for="file"><i class="fa fa-upload"></i> Choose a profile image from your computer</label>
	</div>

	</div>
	</div>
	</div>



      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
				<!-- <input type="submit" value="Submit" class="btn btn-primary" /> -->
				<input type="hidden" name="parent" value="" />
				<input type="hidden" name="id" value="" />
      </div>
			</form>
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="myTree" tabindex="-1" role="dialog" aria-labelledby="myTreeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>





<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>

<script>
    $(document).ready(
        function() {
            var direct_count = <?php echo $count_direct_impacts[0]; ?>;
            var total = $('.pt-thumb').length;
            var indirect = total - 1 - direct_count;

            $('#indirectly-impacted-count').text('' + indirect)
        }
    );
</script>
