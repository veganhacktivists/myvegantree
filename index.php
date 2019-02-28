<?php
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

$view_id = 4;

// let's count all direct impacts, including attached accounts
$bubble_id = db_get('bubbles', 'id', $view_id, 'account_id');

$sql_count_direct_impacts = "
        SELECT COUNT(*)
          FROM ".prefix."bubbles b
     LEFT JOIN ".prefix."requests r ON (b.account_id=r.to_id AND r.accepted=1)
         WHERE (parent = '$bubble_id' OR r.from_id = '$view_id')
           AND type != 2
         ORDER BY r.accepted, b.date ASC";

$count_result = $db->query($sql_count_direct_impacts);
$count_direct_impacts = $count_result->fetch_row();

// logged in? let's redirect from index to their tree URL
if ($lg) {
	echo '<META HTTP-EQUIV="refresh" content="0;URL=/impact">';
}


// echo isset($vp) ;

/*
if($rt == false):
?>
<div class="pt-box">
	<h3>View Password:</h3>

	<form class="pt-form" id="send-vpass">
		<div class="pt-input">
			<i class="icons icon-list"></i>
			<input type="password" name="vpass" placeholder="Write the view password">
		</div>
		<hr />
		<button type="submit" class="pt-button bg-0"><i class="icons icon-login"></i> Submit</button>
		<input type="hidden" name="id" value="<?=$id?>" />
	</form>
</div>
<?php
include_once "footer.php";
exit;
endif;
*/

?>



<style>
.top-container {
  background-color: #f1f1f1;
  padding: 30px;
  text-align: center;
}

.header {
  padding: 10px 16px;
  background: #36a759;
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





<style>
.wrapper {
  border : 0px dotted #ccc; padding: 0px;
}


#sidebar {  }

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

<div class="wrapper">

<?php
	include_once "sidebar.php";
 ?>

<div id="tree">

<div class="header" id="myHeader">
  <h4><i class="fas fa-flag"></i>&nbsp;&nbsp;This is an example tree! Register or login to create or see yours!</h4>
</div>
<div id="color-key">
<div class="input-color" style="background-color: #ffffff;padding: 10px;margin: 15px;width: 230px;border: 1px solid #EEE;border-radius: 10px;">
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
$sql = $db->query("SELECT * FROM ".prefix."accounts WHERE id = '4'");
$id = 4;
if($sql->num_rows){ $rs = $sql->fetch_assoc(); ?>
	<div class="pt-sm">
    <?php
      /* The hard-coded 60px top value below is to stop the tree overlapping the 'This is an example tree' message on the homepage */
    ?>
    <div class="tree" style="top:60px;">
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
	<label for="file"><i class="fa fa-upload"></i> Choose an profile image from your computer</label>
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
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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
