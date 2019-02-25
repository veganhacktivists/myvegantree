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
<!--
<script src="https://cdn.jsdelivr.net/npm/interactjs@1.3.4/dist/interact.min.js"></script>

<script>
// target elements with the "draggable" class
interact('.draggable')
  .draggable({
    // enable inertial throwing
    inertia: true,
    // keep the element within the area of it's parent
    restrict: {
      restriction: "parent",
      endOnly: true,
      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
    },
    // enable autoScroll
    autoScroll: true,

    // call this function on every dragmove event
    onmove: dragMoveListener,
    // call this function on every dragend event
    onend: function (event) {
      var textEl = event.target.querySelector('p');

      textEl && (textEl.textContent =
        'moved a distance of '
        + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
                     Math.pow(event.pageY - event.y0, 2) | 0))
            .toFixed(2) + 'px');
    }
  });

  function dragMoveListener (event) {
    var target = event.target,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    // translate the element
    target.style.webkitTransform =
    target.style.transform =
      'translate(' + x + 'px, ' + y + 'px)';

    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
  }

  // this is used later in the resizing and gesture demos
  window.dragMoveListener = dragMoveListener;

  </script>
-->


<div class="wrapper" style="background-size: cover; background-image: url(https://i.imgur.com/dEqI5GG.png);">

<?php
	include_once "sidebar.php";
 ?>

<div id="tree" class="draggable">

<?php

// lets count how many times a bubble appears under a label
// will need to edit status = variable when we get custom statuses

$label_1 = $db->query("SELECT COUNT(*) FROM mvt_bubbles WHERE status = 'Vegan' && family = '{$id}'")->fetch_array();
$label_2 = $db->query("SELECT COUNT(*) FROM mvt_bubbles WHERE status = 'Vegetarian' && family = '{$id}'")->fetch_array();
$label_3 = $db->query("SELECT COUNT(*) FROM mvt_bubbles WHERE status = 'Plant-Based' && family = '{$id}'")->fetch_array();
$label_4 = $db->query("SELECT COUNT(*) FROM mvt_bubbles WHERE status = 'Getting there' && family = '{$id}'")->fetch_array();

?>

<div id="color-key" style="position: absolute;">
<div class="input-color" style="background-color: #ffffff;padding: 10px;margin: 15px;width: 230px;border: 1px solid #EEE;border-radius: 10px;">
<a href="customize" style="float:right;color: #da6161;"><i>edit</i></a>
<table style="margin: 5px;">
  <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #06bf01;color:#fff;"><i class="fas fa-leaf fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Vegan (<? echo $label_1[0];?>)</td>
  </tr>
  <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #8677e0;color:#fff;"><i class="fab fa-pagelines fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Vegetarian (<? echo $label_2[0];?>)</td>
  </tr>
    <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px;background-color: #4fc9d4;color:#fff;"><i class="fab fa-envira fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Plant-Based (<? echo $label_3[0];?>)</td>
  </tr>
      <tr>
    <td style="padding-top: 2px;"><div class="color-box" style="margin-bottom: 4px;padding-left: 5px;padding-top: 2px; background-color: #da6161;color:#fff;"><i class="fas fa-route fa-fw"></i></div></td>
    <td style="vertical-align: middle;">&nbsp;&nbsp;Getting there (<? echo $label_4[0];?>)</td>
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
$sql = $db->query("SELECT * FROM ".prefix."accounts WHERE id = '{$id}'");

if($sql->num_rows){ $rs = $sql->fetch_assoc(); ?>
	<div class="pt-sm">
	<div class="tree" id="div" style="padding-top: 20px;">
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
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>