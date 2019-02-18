<?php
include __DIR__.'/configs/config.php';


if($pg == 'tree-edit'){
	$sql = $db->query("SELECT * FROM ".prefix."members WHERE id = '{$id}'");
	$rs = $sql->fetch_assoc();
	echo json_encode($rs);
} elseif($pg == 'tree-send'){
	$id = (int)($_POST['id']);

	$data = [
		"name"  => "'".sc_sec($_POST['name'])."'",
		"lastname"   => "'".sc_sec($_POST['lastname'])."'",
		"status"     => "'".sc_sec($_POST['status'])."'",
		"birthday"   => "'".sc_sec($_POST['birthday'])."'",
		"birthmonth" => "'".sc_sec($_POST['birthmonth'])."'",
		"birthyear"  => "'".sc_sec($_POST['birthyear'])."'",
		"deathday"   => "'".sc_sec($_POST['deathday'])."'",
		"deathmonth" => "'".sc_sec($_POST['deathmonth'])."'",
		"deathyear"  => "'".sc_sec($_POST['deathyear'])."'",
		"type"       => "'".(int)($_POST['type'])."'",
		"death"      => "'".(int)($_POST['death'])."'",
		"photo"      => "'".sc_sec($_POST['photo'])."'",
		"email"      => "'".sc_sec($_POST['email'])."'",
		"site"       => "'".sc_sec($_POST['site'])."'",
		"tel"        => "'".sc_sec($_POST['tel'])."'",
		"mobile"     => "'".sc_sec($_POST['mobile'])."'",
		"birthplace" => "'".sc_sec($_POST['birthplace'])."'",
		"deathplace" => "'".sc_sec($_POST['deathplace'])."'",
                "city"       => "'".sc_sec($_POST['city'])."'",
		"profession" => "'".sc_sec($_POST['profession'])."'",
		"company"    => "'".sc_sec($_POST['company'])."'",
		"interests"  => "'".sc_sec($_POST['interests'])."'",
		"bio"        => "'".sc_sec($_POST['bio'])."'"		
	];

	if($id){
		db_update('members', $data, $id);
	} else {
		$data["parent"] = "'".(int)($_POST['parent'])."'";
		$data["family"] = "'".db_get('members', 'family', (int)($_POST['parent']))."'";
		db_insert('members', $data);
	}



	// echo $_POST['death'].'/'.$_POST['gender'].'/'.$_POST['type'];
} elseif($pg == 'user-send'){
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);
	$vpass = sc_sec($_POST['vpass']);
	$email = sc_sec($_POST['email']);

	if(empty($name) || empty($pass) || empty($vpass) || empty($email)){
		$alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
	} elseif(!check_email($email)) {
		$alert = ["type" => "danger", "msg" => fh_alerts("You need a correct email address!")];
	} else {
		$data = [
			"name"     => "'".sc_sec($_POST['name'])."'",
			"password" => "'".sc_pass(sc_sec($_POST['pass']))."'",
			"vpassword" => "'".sc_pass(sc_sec($_POST['vpass']))."'",
			"date"     => "'".time()."'",
			"email"    => "'".sc_sec($_POST['email'])."'"
		];
		db_insert('families', $data);
		db_insert('members', [
			"firstname"     => "'".sc_sec($_POST['name'])."'",
			"family"     => "'".db_get("families", "id", sc_sec($_POST['name']), "name", "&& email = '".sc_sec($_POST['email'])."' && password = '".sc_pass(sc_sec($_POST['pass']))."'")."'",
			"email"    => "'".sc_sec($_POST['email'])."'"
		]);
		$alert = ["type" => "success", "msg" => fh_alerts("Your family ID has created succesfully!", "success")];
	}
	echo json_encode($alert);
} elseif($pg == 'detail-send'){
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);
	$vpass = sc_sec($_POST['vpass']);
	$email = sc_sec($_POST['email']);

	if(empty($name) || empty($email)){
		$alert = ["type" => "danger", "msg" => fh_alerts("Name and Email are required!")];
	} elseif(!check_email($email)) {
		$alert = ["type" => "danger", "msg" => fh_alerts("You need a correct email address!")];
	} else {
		$data = [
			"name"     => "'".sc_sec($_POST['name'])."'",
			"email"    => "'".sc_sec($_POST['email'])."'"
		];
		if($pass){
			$data['password'] = "'".sc_pass(sc_sec($_POST['pass']))."'";
		}

		if($vpass){
			$data['vpassword'] = "'".sc_pass(sc_sec($_POST['vpass']))."'";
		}


		db_update('families', $data, $lg);
		$alert = ["type" => "success", "msg" => fh_alerts("Your family ID has updated succesfully!", "success")];
	}
	echo json_encode($alert);
} elseif($pg == 'login-send'){
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);

	if(empty($name) || empty($pass)){
		$alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
	} else {
		if(db_rows('families WHERE name = "'.$name.'" || email = "'.$name.'"')){
			$sql = db_select([
					'table'  => 'families',
					'where'  => '(name = "'.$name.'" || email = "'.$name.'") && password = "'.sc_pass($pass).'"'
			]);
			if($sql->num_rows){
					$rs = $sql->fetch_assoc();
					$_SESSION['login']  = $rs['id'];
					$alert = ["id" => $rs['id'], "type" => "success", "msg" => fh_alerts("Success! Loading tree...", "success")];
			} else {
				$alert = ["type" => "danger", "msg" => fh_alerts("Family ID or password is incorrect!")];
			}
		} else {
			$alert = ["type" => "danger", "msg" => fh_alerts("Family ID or password is incorrect!")];
		}
	}
	echo json_encode($alert);
} elseif($pg == 'vpass-send'){
 $id  = (int)($_POST['id']);
 $vpass  = sc_sec($_POST['vpass']);

 if(empty($vpass)){
	 $alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
 } else {
	//  if(db_rows('families WHERE vpassword = "'.$name.'" || email = "'.$name.'"')){
		 $sql = db_select([
				 'table'  => 'families',
				 'where'  => 'id = "'.$id.'" && vpassword = "'.sc_pass($vpass).'"'
		 ]);
		 if($sql->num_rows){
				 $rs = $sql->fetch_assoc();
				 $_SESSION['vpass']  = $rs['id'];
				 $alert = ["id" => $rs['id'], "type" => "success", "msg" => fh_alerts("Success! Loading tree...", "success")];
		 } else {
			 $alert = ["type" => "danger", "msg" => fh_alerts("View password is incorrect!")];
		 }
	//  } else {
	// 	 $alert = ["type" => "danger", "msg" => fh_alerts("Family ID or password is incorrect!")];
	//  }
 }
 echo json_encode($alert);
} elseif($pg == "tree-delete"){
	if($lg == db_get("members", "family", $id))
		db_delete("members", $id);
} elseif($pg == "logout"){

		session_unset();
		session_destroy();

}
