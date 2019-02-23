<?php
include __DIR__.'/configs/config.php';
include __DIR__.'/configs/class.upload.php';


$id = (int)($_POST['id']);
$photo = sc_sec($_POST['photo']);

$poll_imgurl = '';

if(file_exists($_FILES['poll_file']['tmp_name']) || !is_uploaded_file($_FILES['poll_file']['tmp_name'])) {
	//echo 'No upload';
} else {
	$dir_dest = 'uploads';
	$handle = new Upload($_FILES['poll_file']);
	if ($handle->uploaded) {
		$handle->file_safe_name = true;
		$fileNewName = base64_encode($handle->file_src_name_body)."_".time();
		$handle->file_new_name_body = $fileNewName;

		$handle->Process($dir_dest);
		if ($handle->processed) {
			$poll_imgurl = $dir_dest.'/' . $handle->file_dst_name;
		} else {
			$alert = ["type" => "danger", "msg" => fh_alerts('File not uploaded to the wanted location<br />Error: ' . $handle->error)];
		}

		$handle->Clean();
	} else {
		$alert = ["type" => "danger", "msg" => fh_alerts('File not uploaded on the server<br />Error: ' . $handle->error)];
	}
}

$photo = ($poll_imgurl) ? $poll_imgurl : $photo;
$data  = [];

$fields = array('name', 'status', 'photo', 'bio');
	// "lastname"   => "'".sc_sec($_POST['lastname'])."'",
	//"birthday"   => "'".sc_sec($_POST['birthday'])."'",
	//"birthmonth" => "'".sc_sec($_POST['birthmonth'])."'",
	//"birthyear"  => "'".sc_sec($_POST['birthyear'])."'",
	// "deathday"   => "'".sc_sec($_POST['deathday'])."'",
	// "deathmonth" => "'".sc_sec($_POST['deathmonth'])."'",
	// "deathyear"  => "'".sc_sec($_POST['deathyear'])."'",
	// "type"       => "'".(int)($_POST['type'])."'",
	// "death"      => "'".(int)($_POST['death'])."'",
	// "email"      => "'".sc_sec($_POST['email'])."'",
	// "site"       => "'".sc_sec($_POST['site'])."'",
	// "tel"        => "'".sc_sec($_POST['tel'])."'",
	// "mobile"     => "'".sc_sec($_POST['mobile'])."'",
	// "birthplace" => "'".sc_sec($_POST['birthplace'])."'",
	// "deathplace" => "'".sc_sec($_POST['deathplace'])."'",
	// "profession" => "'".sc_sec($_POST['profession'])."'",
	// "company"    => "'".sc_sec($_POST['company'])."'",
	// "interests"  => "'".sc_sec($_POST['interests'])."'",

foreach ($fields as $field) {
	if ($field == 'photo') {
		$data[$field] = "'$photo'";
	} else {
		$data[$field] = "'".sc_sec($_POST[$field])."'";
	}
}


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

// echo json_encode($array_msg);
// echo $photo;
