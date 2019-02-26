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
		try {
			db_update('bubbles', $data, $id);
		} catch (Exception $e) {
			error_log( 'Mysql error: '.$e->getMessage() );
		}
	} else {
		$data["parent"] = "'".(int)($_POST['parent'])."'";
		$data["family"] = "'".db_get('bubbles', 'family', (int)($_POST['parent']))."'";
		try {
			db_insert('bubbles', $data);
		} catch (Exception $e) {
			error_log( 'Mysql error: '.$e->getMessage() );
		}
	}



	// echo $_POST['death'].'/'.$_POST['gender'].'/'.$_POST['type'];
} elseif($pg == 'user-send'){
	$name  = sc_sec($_POST['username']);
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);
	$vpass = sc_sec($_POST['vpass']);
	$email = sc_sec($_POST['email']);

	if(empty($username) || empty($name) ||empty($pass) || empty($vpass) || empty($email)){
		$alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
	} elseif(!check_email($email)) {
		$alert = ["type" => "danger", "msg" => fh_alerts("You need a correct email address!")];
	} else {
		$data = [
			"username"     => "'".sc_sec($_POST['username'])."'",
			"name"     => "'".sc_sec($_POST['name'])."'",
			"password" => "'".sc_pass(sc_sec($_POST['pass']))."'",
			"vpassword" => "'".sc_pass(sc_sec($_POST['vpass']))."'",
			"email"    => "'".sc_sec($_POST['email'])."'"
		];
		try {
			$account_id = db_insert('accounts', $data);
			db_insert('bubbles', [
				'account_id' => $account_id,
				'name'       => "'".sc_sec($_POST['name'])."'",
				'family'     => $account_id
			]);
		} catch (Exception $e) {
			error_log( 'Mysql error: '.$e->getMessage() );
		}
		$alert = ["type" => "success", "msg" => fh_alerts("Your Username has created succesfully!", "success")];
	}
	echo json_encode($alert);
} elseif($pg == 'detail-send'){
	$username  = sc_sec($_POST['username']);
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);
	$vpass = sc_sec($_POST['vpass']);
	$email = sc_sec($_POST['email']);

	if(empty($username) || empty($name) || empty($email)){
		$alert = ["type" => "danger", "msg" => fh_alerts("Username, Name, and Email are required!")];
	} elseif(!check_email($email)) {
		$alert = ["type" => "danger", "msg" => fh_alerts("You need a correct email address!")];
	} else {
		$data = [
			"username"     => "'".sc_sec($_POST['username'])."'",
			"name"     => "'".sc_sec($_POST['name'])."'",
			"email"    => "'".sc_sec($_POST['email'])."'"
		];
		if($pass){
			$data['password'] = "'".sc_pass(sc_sec($_POST['pass']))."'";
		}

		if($vpass){
			$data['vpassword'] = "'".sc_pass(sc_sec($_POST['vpass']))."'";
		}


		try {
			db_update('accounts', $data, $lg);
		} catch (Exception $e) {
			error_log( 'Mysql error: '.$e->getMessage() );
		}
		$alert = ["type" => "success", "msg" => fh_alerts("Your Username has updated succesfully!", "success")];
	}
	echo json_encode($alert);
} elseif($pg == 'login-send'){
	$username  = sc_sec($_POST['username']);
	$pass  = sc_sec($_POST['pass']);

	if(empty($username) || empty($pass)){
		$alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
	} else {
		$sql = db_select(['table' => 'accounts', 'where' => '(username = "' . $username . '" || email = "' . $username . '")']);
		if($sql->num_rows)
		{
			$result = $sql->fetch_assoc();
			$passwordHash = $result["password"];
			if($pass == sc_dehash($passwordHash, $pass))
			{
				$_SESSION['login'] = $result['id'];
				$alert = ["id" => $result['id'], "type" => "success", "msg" => fh_alerts("Success! Loading tree...", "success")];
			} else {
				$alert = ["type" => "danger", "msg" => fh_alerts("Username or password is incorrect!")];
			}
		} else {
			$alert = ["type" => "danger", "msg" => fh_alerts("Username or password is incorrect!")];
		}
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
	// 	 $alert = ["type" => "danger", "msg" => fh_alerts("Username or password is incorrect!")];
	//  }
 }
 echo json_encode($alert);
} elseif($pg == "tree-delete"){
	if($lg == db_get("bubbles", "family", $id))
		db_delete("bubbles", $id);

} elseif($pg == 'request-send') {
	$user = (int) $_POST['user_id'];

	// Validation
	$invalid = db_count('requests', 'idrequests', "WHERE to_id = $lg AND from_id = $user AND accepted = 1");
	if ($invalid) {
		$alert = ['type' => 'danger', 'msg' => fh_alerts("You've already accepted a request from this user")];
		echo json_encode($alert);
		exit;
	}
	$exists = db_count('accounts', 'id', "WHERE id = $user AND id != $lg");
	if (!$exists) {
		$alert = ['type' => 'danger', 'msg' => fh_alerts("Invalid user ID")];
		echo json_encode($alert);
		exit;
	}

	$data = [
		'from_id'  => $lg,
		'to_id'    => $user,
		'accepted' => 0
	];
	try {
		db_insert('requests', $data);
		$alert = ['type' => 'success', 'msg' => fh_alerts('Tree request sent succesfully!', 'success')];
	} catch (Exception $e) {
		error_log( 'Mysql error: '.$e->getMessage() );
		$alert = ['type' => 'danger', 'msg' => fh_alerts('Failed to make tree request')];
	}
	echo json_encode($alert);

} elseif($pg == 'request-accept') {
	$id = (int) $_POST['request_id'];
	$data = [ 'accepted' => 1 ];
	try {
		db_update('requests', $data, $id, 'idrequests');
		$alert = ['type' => 'success', 'msg' => fh_alerts('Request approval accepted succesfully!', 'success')];
	} catch (Exception $e) {
		error_log( 'Mysql error: '.$e->getMessage() );
		$alert = ['type' => 'danger', 'msg' => fh_alerts('Failed to accept tree request')];
	}
	echo json_encode($alert);

} elseif($pg == 'request-revoke') {
	$id = (int) $_POST['request_id'];
	$data = [ 'accepted' => 0, 'ignored' => 1 ];
	try {
		db_update('requests', $data, $id, 'idrequests');
		$alert = ['type' => 'success', 'msg' => fh_alerts('Request approval revoked succesfully!', 'success')];
	} catch (Exception $e) {
		error_log( 'Mysql error: '.$e->getMessage() );
		$alert = ['type' => 'danger', 'msg' => fh_alerts('Failed to revoke tree request')];
	}
	echo json_encode($alert);

} elseif($pg == "logout"){

		session_unset();
		session_destroy();

}
?>
