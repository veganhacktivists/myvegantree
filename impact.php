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


$check_if_tree_public = $public;

$view_name = isset($_GET['name']) ? sc_sec($_GET['name']) : $username;
$view_account = db_get('accounts', 'id,public', $view_name, 'username');

if( is_null( $view_account ) ) {
    header( 'Location: /' );
    die();
}

$view_id = $view_account['id'];
$check_if_tree_public = $view_account['public'];

// let's count all direct impacts, including attached accounts
$bubble_id = db_get('bubbles', 'id', $view_id, 'account_id');
$sql_count_direct_impacts = "
        SELECT COUNT(*)
          FROM ".prefix."bubbles b
     LEFT JOIN ".prefix."requests r ON (b.account_id=r.to_id AND r.accepted=1)
         WHERE (parent = $bubble_id OR r.from_id = $view_id )
           AND type != 2
         ORDER BY r.accepted, b.date ASC";
$result = $db->query($sql_count_direct_impacts);
$count_direct_impacts = $result ? $result->fetch_row() : 0;

if ($lg && $lg == $view_id) {
	// never lock the tree if you're logged in on your own tree
} elseif ($vp == $view_id) {
	// View acccess via password
} else {

	if($check_if_tree_public == 2) {
		echo '<div class="pt-box">
			<h3 style="padding: 21px 0px 14px 0px;font-size: 24px;">This tree has been set to private!</h3>

			<form class="pt-form" id="send-vpass">
				<div class="pt-input">
					<i class="icons icon-list"></i>
					<input type="password" name="vpass" placeholder="Submit tree password">
				</div>
				<hr />
				<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> View tree</button>
				<input type="hidden" name="id" value="'. $view_id . '" />
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

<div id="color-key">
<div class="input-color" style="background-color: #ffffff;padding: 10px;margin: 15px;width: 230px;border: 1px solid #EEE;border-radius: 10px;">
<a href="customize" style="float:right;color: #da6161;"><i>edit</i></a>
<table style="margin: 5px;">
  <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #06bf01;color:#fff;"><i class="fas fa-leaf fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Vegan (<b id="vegan-label-count">23</b>)</td>
  </tr>
  <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #8677e0;color:#fff;"><i class="fab fa-pagelines fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Vegetarian (<b id="vegetarian-label-count">23</b>)</td>
  </tr>
    <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #4fc9d4;color:#fff;"><i class="fab fa-envira fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Plant-Based (<b id="plantbased-label-count">23</b>)</td>
  </tr>
      <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px; background-color: #da6161;color:#fff;"><i class="fas fa-route fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Getting there (<b id="gettingthere-label-count">23</b>)</td>
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

  $sql = $db->query("SELECT * FROM ".prefix."accounts WHERE id = $view_id");
  if($sql->num_rows){ $rs = $sql->fetch_assoc(); ?>
	<div class="tree">
    <div class="tree-inner">
    <?php if(db_count("bubbles WHERE family = '{$rs['id']}'")): ?>
      <ul>
        <?php
          $sql_m = $db->query("SELECT * FROM ".prefix."bubbles WHERE family = '{$rs['id']}' && parent = 0 ORDER BY date ASC");
          while($rs_m = $sql_m->fetch_assoc()){
            echo get_child($rs_m['id'], $view_id, 0);
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
	<select name="label_id">
    <?php
        $res = $db->query( sprintf( 'SELECT * from %slabels where account_id = %d or account_id IS NULL', prefix, $_SESSION[ 'login' ] ) );
        while( $label = $res->fetch_assoc() )
            printf( '<option value="%d">%s</option>', $label[ 'id' ], $label[ 'name' ] );
    ?>
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

			var total_vegan = $('.Vegan').length;
			var total_vegetarian = $('.Vegetarian').length;
			var total_plantbased = $('.Plant-Based').length;
			var total_gettingthere = $('.Gettingthere').length;

            $('#vegan-label-count').text('' + total_vegan);
			$('#vegetarian-label-count').text('' + total_vegetarian);
			$('#plantbased-label-count').text('' + total_plantbased);
			$('#gettingthere-label-count').text('' + total_gettingthere);

            $('#indirectly-impacted-count').text('' + indirect)
        }
    );
</script>
