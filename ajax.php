<?php
include __DIR__.'/configs/config.php';


if($pg == 'tree-edit'){
	$sql = $db->query("SELECT * FROM ".prefix."bubbles WHERE id = '{$id}'");
	$rs = $sql->fetch_assoc();
	echo json_encode($rs);
} elseif($pg == 'tree-send'){
	$id = (int)($_POST['id']);

	$data = [
		"name"  => "'".sc_sec($_POST['name'])."'",
		"status"     => "'".sc_sec($_POST['status'])."'",
		"type"       => "'".(int)($_POST['type'])."'",
		"photo"      => "'".sc_sec($_POST['photo'])."'",
		"attached"      => "'".sc_sec($_POST['attached'])."'",
		"date"      => "'".sc_sec($_POST['date'])."'",
		"bio"        => "'".sc_sec($_POST['bio'])."'"
	];

	if($id){
		db_update('bubbles', $data, $id);
	} else {
		$data["parent"] = "'".(int)($_POST['parent'])."'";
		$data["family"] = "'".db_get('bubbles', 'family', (int)($_POST['parent']))."'";
		db_insert('bubbles', $data);
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
		db_insert('accounts', $data);
		db_insert('bubbles', [
			"name"     => "'".sc_sec($_POST['name'])."'",
			"family"     => "'".db_get("accounts", "id", sc_sec($_POST['name']), "name", "&& email = '".sc_sec($_POST['email'])."' && password = '".sc_pass(sc_sec($_POST['pass']))."'")."'",
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


		db_update('accounts', $data, $lg);
		$alert = ["type" => "success", "msg" => fh_alerts("Your family ID has updated succesfully!", "success")];
	}
	echo json_encode($alert);
} elseif($pg == 'login-send'){
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);

	if(empty($name) || empty($pass)){
		$alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
	} else {
		$sql = db_select(['table' => 'accounts', 'where' => '(name = "' . $name . '" || email = "' . $name . '")']);
		if($sql->num_rows)
		{
			$result = $sql->fetch_assoc();
			$passwordHash = $result["password"];
			if($pass == sc_dehash($passwordHash, $pass))
			{
				$_SESSION['login'] = $result['id'];
				$alert = ["id" => $result['id'], "type" => "success", "msg" => fh_alerts("Success! Loading tree...", "success")];
			} else {
				$alert = ["type" => "danger", "msg" => fh_alerts("Family ID or password is incorrect!")];
			}
		} else {
			$alert = ["type" => "danger", "msg" => fh_alerts("Family ID or password is incorrect!")];
		}
/*
		if(db_rows('accounts WHERE name = "'.$name.'" || email = "'.$name.'"')){
			$sql = db_select([
					'table'  => 'accounts',
					'column' => 'password',
					'where'  => '(name = "'.$name.'" || email = "'.$name.'") && password = "'.sc_dehash($pass).'"'
			]);
			if($sql->num_rows){
					$rs = $sql->fetch_assoc();
					$_SESSION['login']  = $rs['id'];
					$alert = ["id" => $rs['id'], "type" => "success", "msg" => fh_alerts("Success! Loading tree...", "success")];

			}
		} */
	}
	echo json_encode($alert);
} elseif($pg == 'vpass-send'){
 $id  = (int)($_POST['id']);
 $vpass  = sc_sec($_POST['vpass']);

 if(empty($vpass)){
	 $alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
 } else {
	//  if(db_rows('accounts WHERE vpassword = "'.$name.'" || email = "'.$name.'"')){
		 $sql = db_select([
				 'table'  => 'accounts',
				 'where'  => 'id = "'.$id.'" && vpassword = "'.sc_dehash($vpass).'"'
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
	if($lg == db_get("bubbles", "family", $id))
		db_delete("bubbles", $id);
} elseif($pg == "logout"){

		session_unset();
		session_destroy();

}
