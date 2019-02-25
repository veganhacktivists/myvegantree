<?php

function get_child($cid, $attached){
	global $db, $lg, $id;

	$bubble = db_get('bubbles', '*', $cid);

	$list = '';
	$list .= '<li>';
	$list .= '<a>';
	$list .= '<div class="pt-thumb" style="">';

	$u_color = '#dedede';
	if ($id == $bubble['account_id'])  {
	$u_color = '#da6161'; }
	elseif ($attached) {
    $u_color = '#da6161';
	}

	$list .= '<i class="fas fa-users" style="font-size: 17px;position: absolute;margin: 10px;color: '.$u_color.';""></i>';
	$list .= '<i class="fas fa-user" style="font-size: 17px;position: absolute;padding-left: 144px;padding-top: 9px;color: #666666;""></i>';

	/*
	Semantic popup below, to appear when hovering over the fa-user icon..

	$list .= '
	<div class="ui flowing popup top left transition hidden">
	<div class="ui three column divided center aligned grid">
    <div class="column">
	<h4 class="ui header">Private Note</h4>
	<p>[insert note from database]</p>
	<div class="ui button">Edit User</div>
    </div>
	</div>
	</div>';
	*/


	// this code randomize default profile pictures on load with a bunch of different faces
	$default_profile_pictures = array(
			'https://myvegantree.org/images/default-profile-pics/1.png',
            'https://myvegantree.org/images/default-profile-pics/2.png',
			'https://myvegantree.org/images/default-profile-pics/3.png',
			'https://myvegantree.org/images/default-profile-pics/4.png',
			'https://myvegantree.org/images/default-profile-pics/5.png',
			'https://myvegantree.org/images/default-profile-pics/6.png',
			'https://myvegantree.org/images/default-profile-pics/7.png',
			'https://myvegantree.org/images/default-profile-pics/8.png',
            'https://myvegantree.org/images/default-profile-pics/9.png'
        );

	$i = rand(0, count($default_profile_pictures)-1); // generate random number size of the array
	$selectedBg = "$default_profile_pictures[$i]"; // set variable equal to which random filename was chosen



	$list .= '<img style="margin-top: 10px;margin-left: 10px;margin-bottom: 5px;margin-right: 10px;width: 150px;height: 150px;object-fit: cover;border-radius: 100%;" src="'.$bubble['photo'].'" onerror="this.src=\''.$selectedBg.'\'" />';
	$list .= '</div>';
	$list .= '<strong style="font-size: 20px;">'.$bubble['name'].'</strong>';


	if (preg_match('/vegan/i', $bubble['status'])) {
		$list .= '<div id="Vegan" style="margin-top: 3px;background-color: #06bf01;"><i style="font-size: 14px;color: #fff;border-radius: 25px;background-color: #06bf01;"><i class="fas fa-leaf"></i>&nbsp;&nbsp;Vegan</i></div>';
	} else if (preg_match('/vegetarian/i', $bubble['status'])) {
		$list .= '<div id="Vegetarian" style="margin-top: 3px;background-color: #8677e0;"><i style="font-size: 14px;color: #fff;border-radius: 25px;background-color: #8677e0;"><i class="fab fa-pagelines"></i>&nbsp;&nbsp;Vegetarian</i></div>';
	} else if (preg_match('/plant\-based/i', $bubble['status'])) {
		$list .= '<div id="Plant-Based" style="margin-top: 3px;background-color: #4fc9d4;"><i style="font-size: 14px;color: #fff;border-radius: 25px;background-color: #4fc9d4;"><i class="fab fa-envira"></i>&nbsp;&nbsp;Plant-Based</i></div>';
	} else if (preg_match('/getting there/i', $bubble['status'])) {
		$list .= '<div id="Getting there" style="margin-top: 3px;background-color: #da6161;"><i style="font-size: 14px;color: #fff;border-radius: 25px;background-color: #da6161;"><i class="fas fa-route"></i>&nbsp;&nbsp;Getting there</i></div>';
	}

	// Edit buttons
	if($lg && $lg == $id && !$attached){
		$list .= '<span class="pt-options">';
		$list .= '<i style="font-size: 20px;margin: 10px;float: left;" class="fas fa-user-edit tree-edit" rel="'.$cid.'"></i>';
		$list .= '<i style="font-size: 20px;margin: 10px;float: right;" class="fas fa-plus-circle tree-add" rel="'.$cid.'" data-toggle="modal" data-target="#myModal"></i>';


		if ($id == $bubble['account_id']) {
		// do not allow deletion of this bubble (main account bubble)
		$list .= '<i style="font-size: 20px;margin: 10px;float: center;color: #e7e8ea;" class="fas fa-trash-alt"></i>';
		} else {
		$list .= '<i style="font-size: 20px;margin: 10px;float: center;" class="fas fa-trash-alt trash-alert icon"></i>';
		}

		$list .= '<div class="ui flowing popup transition hidden">
					  <div class="ui divided center aligned grid" style="margin: 0px 100px 0px -7px;padding: 0px 10px 2px 10px;">
					  	  <div class="row" style="padding: 10px 0px 0px 0px;">
				  	  		<h4 class="ui header" style="font-size: 15px;">Are you sure you want to delete '.$bubble['name'].'\'s bubble?</h4>
					  	  </div>
					      <div class="row">
					        <div class="ui red button tree-delete" rel="'.$cid.'" style="font-size: 15px;">Delete</div>
					  	  </div>
					  </div>
					</div>';
		$list .= '</span>';
	}




	// tree-delete
	// rel="'.$cid.'"


	$list .= '</a>';

	if ($attached == '1') {
		$list .= 'test';
	}

	$get_children = "
        SELECT *
          FROM ".prefix."bubbles b
     LEFT JOIN ".prefix."requests r ON (b.account_id=r.to_id AND r.accepted=1)
         WHERE (parent = '{$cid}' OR r.from_id = '{$bubble['account_id']}')
           AND type != 2
         ORDER BY r.accepted, b.date ASC";

	$sql_m = $db->query($get_children);
	if($sql_m->num_rows){
		$list .= '<ul>';
		while($rs_m = $sql_m->fetch_assoc()){
			$attached = ($attached || $rs_m['accepted']) ? 1 : 0;
			$list .= get_child($rs_m['id'], $attached);
		}
		$list .= '</ul>';
		$sql_m->close();
	}

	$list .= '</li>';

	return $list;
}
