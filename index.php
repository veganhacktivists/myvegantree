<?php
// make code below redirect to your tree if you try going to index.... broken
//$URL="/Test/tree.php?id=";
//echo "<script type='text/javascript'>document.location.href='{$URL}{$id}';</script>";
//echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL + $id.'">';
////////////////////////////////////////////

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

function get_child($cid){
	global $db, $lg, $id;

	// grab status of member such as: vegan, vegetarian, plant-based, getting there, custom status, ect...
	$status = db_get('members', 'status', $cid);
	// grab variable to see if member is "manually added" or if the member is attached via username from other account...
	$attached = db_get('members', 'attached', $cid);

	$id = db_get('members', 'id', $cid);

	$list = '';
	$list .= '<li>';
	$list .= '<a rel="item-'.$cid.'"'.(db_get('members', 'type', $cid)==2?' class="partner"':'').'>';
	$list .= '<div class="pt-thumb" style="">';

		if ($attached == 1) {
		$list .= '<i class="fas fa-user-check" style="font-size: 17px;position: absolute;margin: 10px;color: #da6161;""></i>';
		} else {
		$list .= '<i class="fas fa-user-check" style="font-size: 17px;position: absolute;margin: 10px;color: #dedede;""></i>';
		}

	$list .= '<img style="margin-top: 10px;margin-left: 10px;margin-bottom: 5px;margin-right: 10px;width: 150px;height: 150px;object-fit: cover;border-radius: 100%;" src="'.db_get('members', 'photo', $cid).'" onerror="this.src=\'http://funedge.co.id/assets/img/no_profile_pic.jpg\'" />';
	$list .= '</div>';
	$list .= '<strong style="font-size: 20px;">'.db_get('members', 'name', $cid).'</strong>';


		if ($status == 'Vegan') {
			$list .= '<div id="Vegan" style="margin-top: 3px;background-color: #06bf01;"><i style="font-size: 14px;color: #fff;border-radius: 25px;background-color: #06bf01;"><i class="fas fa-leaf"></i>&nbsp;&nbsp;Vegan</i></div>';
		} else if ($status == 'Vegetarian') {
			$list .= '<div id="Vegetarian" style="margin-top: 3px;background-color: #8677e0;"><i style="font-size: 14px;color: #fff;border-radius: 25px;background-color: #8677e0;"><i class="fab fa-pagelines"></i>&nbsp;&nbsp;Vegetarian</i></div>';
		} else if ($status == 'Plant-Based') {
			$list .= '<div id="Plant-Based" style="margin-top: 3px;background-color: #4fc9d4;"><i style="font-size: 14px;color: #fff;border-radius: 25px;background-color: #4fc9d4;"><i class="fab fa-envira"></i>&nbsp;&nbsp;Plant-Based</i></div>';
		} else if ($status == 'Getting there') {
			$list .= '<div id="Getting there" style="margin-top: 3px;background-color: #da6161;"><i style="font-size: 14px;color: #fff;border-radius: 25px;background-color: #da6161;"><i class="fas fa-route"></i>&nbsp;&nbsp;Getting there</i></div>';
		}



	$list .= '</a>';

	$sql_m = $db->query("SELECT * FROM ".prefix."members WHERE parent = '{$cid}' && type != 2 ORDER BY birthyear ASC");
	if($sql_m->num_rows){
		$list .= '<ul>';
		while($rs_m = $sql_m->fetch_assoc()){
			$list .= get_child($rs_m['id']);
		}
		$list .= '</ul>';
		$sql_m->close();
	}

	$list .= '</li>';

	return $list;
}

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

<div class="wrapper">

<?php
	include_once "sidebar.php";
 ?>

<div id="tree">
<div class="header" id="myHeader">
  <h4><i class="fas fa-flag"></i>&nbsp;&nbsp;This is an example tree! Register or login to create or see yours!</h4>
</div>
<div id="color-key" style="position: absolute;">
<div class="input-color" style="background-color: #ffffff;padding: 10px;margin: 15px;width: 230px;border: 1px solid #EEE;border-radius: 10px;">
<a href="" style="float:right;color: #da6161;"><i>edit</i></a>
<table style="margin: 5px;">
  <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #06bf01;color:#fff;"><i class="fas fa-leaf fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Vegan (3)</td>
  </tr>
  <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #8677e0;color:#fff;"><i class="fab fa-pagelines fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Vegetarian (12)</td>
  </tr>
    <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #4fc9d4;color:#fff;"><i class="fab fa-envira fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Plant-Based (1)</td>
  </tr>
      <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px; background-color: #da6161;color:#fff;"><i class="fas fa-route fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Getting there (25)</td>
  </tr>
</table>

</div>

<div class="input-color" style="background-color: #ffffff;padding: 10px;margin: 15px;width: 230px;border: 1px solid #EEE;border-radius: 10px;">
<table style="width: 100%;margin: 5px;">
 <tr>
    <td><i class="fas fa-star"></i>&nbsp;&nbsp;Directly impacted:&nbsp;&nbsp;</div></td>
    <td style="text-align:left;"><b>6</b></td>
  </tr>
   <tr>
    <td><i class="fas fa-star-half-alt"></i>&nbsp;&nbsp;Indirectly impacted:&nbsp;&nbsp;</div></td>
    <td style="text-align:left;"><b>23</b></td>
  </tr>
</table>
</div>
</div>



<?php
$sql = $db->query("SELECT * FROM ".prefix."families WHERE id = '4'");

if($sql->num_rows){ $rs = $sql->fetch_assoc(); ?>
	<div class="pt-sm">
	<div class="tree" id="div" style="padding-top: 20px;">
	<?php if(db_count("members WHERE family = '{$rs['id']}'")): ?>
	<ul>
	<?php
	$sql_m = $db->query("SELECT * FROM ".prefix."members WHERE family = '{$rs['id']}' && parent = 0 ORDER BY birthyear ASC");
	while($rs_m = $sql_m->fetch_assoc()){
	echo get_child($rs_m['id']);
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
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>
