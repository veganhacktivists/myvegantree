<?php
include __DIR__.'/configs/config.php';
include __DIR__.'/configs/class.upload.php';


$id = (int)($_POST['id']);
$photo = sc_sec($_POST['photo']);


$poll_imgurl = '';

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

	$handle-> Clean();
} else {
	$alert = ["type" => "danger", "msg" => fh_alerts('File not uploaded on the server<br />Error: ' . $handle->error)];
}

$photo = ($poll_imgurl) ? $poll_imgurl : $photo;


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
	"photo"      => "'".$photo."'",
	"email"      => "'".sc_sec($_POST['email'])."'",
	"site"       => "'".sc_sec($_POST['site'])."'",
	"tel"        => "'".sc_sec($_POST['tel'])."'",
	"mobile"     => "'".sc_sec($_POST['mobile'])."'",
	"birthplace" => "'".sc_sec($_POST['birthplace'])."'",
	"deathplace" => "'".sc_sec($_POST['deathplace'])."'",
	"profession" => "'".sc_sec($_POST['profession'])."'",
	"company"    => "'".sc_sec($_POST['company'])."'",
	"interests"  => "'".sc_sec($_POST['interests'])."'",
	"bio"        => "'".sc_sec($_POST['bio'])."'"
];

if($id){
	db_update('bubbles', $data, $id);
} else {
	$data["parent"] = "'".(int)($_POST['parent'])."'";
	$data["family"] = "'".db_get('bubbles', 'family', (int)($_POST['parent']))."'";
	db_insert('bubbles', $data);
}




// echo json_encode($array_msg);
// echo $photo;
