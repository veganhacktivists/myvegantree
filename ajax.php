<?php
include __DIR__.'/configs/config.php';

if($pg == 'tree-edit'){
	$edit_id = (int)($_GET['id']);
	$sql = $db->query("SELECT * FROM ".prefix."bubbles WHERE id = $edit_id");
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


} elseif($pg == 'user-send'){
    $username  = sc_sec($_POST['username']);
    $name  = sc_sec($_POST['name']);
    $pass  = sc_sec($_POST['pass']);
    $vpass = sc_sec($_POST['vpass']);
    $email = sc_sec($_POST['email']);

    if(empty($username) || empty($name) ||empty($pass) || empty($vpass) || empty($email)){
        $alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
    } elseif(db_count('accounts', 'username', 'WHERE username = "'.$username.'"')){
        $alert = ["type" => "danger", "msg" => fh_alerts("That username already exists!")];
	} elseif(db_count('accounts', 'email', 'WHERE email = "'.$email.'"')){
        $alert = ["type" => "danger", "msg" => fh_alerts("A user with that email is already registered!")];
    } elseif(!check_email($email)) {
        $alert = ["type" => "danger", "msg" => fh_alerts("You need a correct email address!")];
	} else {
		$data = [
			"username"     => "'".$username."'",
			"name"     => "'".$name."'",
			"password" => "'".sc_pass($pass)."'",
			"vpassword" => "'".sc_pass($vpass)."'",
			"email"    => "'".sc_sec($_POST['email'])."'"
		];
		try {
			$account_id = db_insert('accounts', $data);
			db_insert('bubbles', [
				'account_id' => $account_id,
				'name'       => "'".sc_sec($_POST['name'])."'",
				'family'     => $account_id
			]);

			$vars = Array();
			$result = db_get('accounts', 'name,username,email', $account_id);
			$_SESSION['login'] = $account_id;
			$vars['name']      = $_SESSION['name']     = $result['name'];
			$vars['email']     = $_SESSION['email']    = $result['email'];
			$vars['username']  = $_SESSION['username'] = $result['username'];

			#send registration email
			$content = file_get_contents("templates/registration_welcome.html");
			foreach ( $vars as $key => $value ) {
				$content = preg_replace('/{{ '.$key.' }}/', $value, $content);
			}
			$subject  = "Welcome to My Vegan Tree!";
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8\r\n";
			$headers .= "From: no-reply@myvegantree.org\r\n";

			$sent = mail($result['email'], $subject, $content, $headers, '-f no-reply@myvegantree.org');
			if (!$sent) {
				$error = error_get_last()['message'];
				error_log($error);
			}

		} catch (Exception $e) {
			error_log( 'Mysql error: '.$e->getMessage() );
		}
		$alert = ["type" => "success", "msg" => fh_alerts("Your registration is successful! One moment please...", "success")];
	}
	echo json_encode($alert);



} elseif($pg == 'detail-send'){
	$username  = sc_sec($_POST['username']);
	$name  = sc_sec($_POST['name']);
	$pass  = sc_sec($_POST['pass']);
	$vpass = sc_sec($_POST['vpass']);
	$public = sc_sec($_POST['public']);
	$email = sc_sec($_POST['email']);

	if(empty($username) || empty($name) || empty($email)){
		$alert = ["type" => "danger", "msg" => fh_alerts("Username, Name, and Email are required!")];
	} elseif(!check_email($email)) {
		$alert = ["type" => "danger", "msg" => fh_alerts("You need a correct email address!")];
	} else {
		$data = [
			"username"     => "'".sc_sec($_POST['username'])."'",
			"name"     => "'".sc_sec($_POST['name'])."'",
			"public"     => "'".sc_sec($_POST['public'])."'",
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
				$_SESSION['login']    = $result['id'];
				$_SESSION['name']     = $result['name'];
				$_SESSION['username'] = $result['username'];
				$_SESSION['public']   = $result['public'];

				$alert = ["id" => $result['id'], "username" => $result['username'], "type" => "success", "msg" => fh_alerts("Success! Loading tree...", "success")];
			} else {
				$alert = ["type" => "danger", "msg" => fh_alerts("Username or password is incorrect!")];
			}
		} else {
			$alert = ["type" => "danger", "msg" => fh_alerts("Username or password is incorrect!")];
		}
	}
	echo json_encode($alert);
}
elseif($pg == 'vpass-send'){
 $id  = (int)($_POST['id']);
 $vpass  = sc_sec($_POST['vpass']);

 if(empty($vpass)){
     $alert = ["type" => "danger", "msg" => fh_alerts("All fields are required!")];
 } else {
         $sql = db_select([
                 'table'  => 'accounts',
                 'where'  => 'id = "'.$id.'"'
         ]);
         if($sql->num_rows){
                 $rs = $sql->fetch_assoc();
                 if (sc_dehash($rs['vpassword'], $vpass)) {
                     $_SESSION['vpass'] = $rs['id'];
                     $alert = ["id" => $rs['id'], "type" => "success", "msg" => fh_alerts("Success! Loading tree...", "success")];
                 }
         } else {
             $alert = ["type" => "danger", "msg" => fh_alerts("View password is incorrect!")];
         }
 }
 echo json_encode($alert);

} elseif($pg == "tree-delete"){
	$delete_id = (int)($_GET['id']);
	if($lg == db_get("bubbles", "family", $delete_id))
		db_delete("bubbles", $delete_id);

} elseif($pg == 'request-send') {
	$username = sc_sec($_POST['username']);

	// Validation
	$account_id = db_get('accounts', 'id', $username, 'username');
	if (!$account_id) {
		$alert = ['type' => 'danger', 'msg' => fh_alerts("Unable to find user, '$username'")];
		echo json_encode($alert);
		exit;
	}
	$invalid = db_count('requests', 'idrequests', "WHERE to_id = $lg AND from_id = $account_id AND accepted = 1");
	if ($invalid) {
		$alert = ['type' => 'danger', 'msg' => fh_alerts("You've already accepted a request from this user")];
		echo json_encode($alert);
		exit;
	}
	$exists = db_count('accounts', 'id', "WHERE id = $account_id AND id != $lg");
	if (!$exists) {
		$alert = ['type' => 'danger', 'msg' => fh_alerts("Invalid user ID")];
		echo json_encode($alert);
		exit;
	}

	$data = [
		'from_id'  => $lg,
		'to_id'    => $account_id,
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

} elseif($pg == 'request-cancel') {
	$id = (int) $_POST['request_id'];
	try {
		db_delete('requests', $id, 'idrequests');
		$alert = ['type' => 'success', 'msg' => fh_alerts('Request cancelled succesfully!', 'success')];
	} catch (Exception $e) {
		error_log( 'Mysql error: '.$e->getMessage() );
		$alert = ['type' => 'danger', 'msg' => fh_alerts('Failed to cancel request')];
	}
	echo json_encode($alert);


} elseif($pg == 'add-label') {
    $name  = sc_sec($_POST['name'],true);
	$color = $_POST['color'];
	$icon = sc_sec($_POST['icon']);

    if( !empty( $name ) && preg_match( '/#[0-9A-Fa-f]{6}/', $color ) && !empty( $icon ) ) {
        $id = db_insert( 'labels', [ 'name' => '"'.$name.'"', 'account_id' => $_SESSION['login'], 'color' => '"'.$color.'"', 'icon' => '"'.$icon.'"' ] );
        $alert = [ 'success' => true, 'id' => $id ];
    } else
        $alert = [ 'success' => false ];


    echo json_encode($alert);

} elseif($pg == 'edit-label') {

    $id = (int) $_POST[ 'id' ];
    $name  = sc_sec($_POST['name'],true);
	$color = $_POST['color'];
	$icon = sc_sec($_POST['icon']);

    if( !empty( $name ) && preg_match( '/#[0-9A-Fa-f]{6}/', $color ) && !empty( $icon ) ) {

		$query = sprintf( "UPDATE %slabels SET name = '%s', color = '%s', icon = '%s' WHERE id = %d and account_id = %d ", prefix, $name, $color, $icon, $id, $_SESSION['login'] );
		$res = $db->query($query);

		if( $res )
			$alert = [ 'success' => true ];
		else
			$alert = [ 'success' => false, 'error' => $db->error ];
    } else
        $alert = [ 'success' => false ];

    echo $res;
    echo json_encode($alert);

} elseif($pg == 'delete-label') {

    $id = (int) $_POST[ 'id' ];

	$query = sprintf( "DELETE FROM %slabels WHERE id = %d and account_id = %d ", prefix, $id, $_SESSION['login'] );
	$res = $db->query($query);

	if( $res )
		$alert = [ 'success' => true ];
	else
		$alert = [ 'success' => false, 'error' => $db->error ];

    echo json_encode($alert);

} elseif($pg == "logout"){

		session_unset();
		session_destroy();

}
?>
