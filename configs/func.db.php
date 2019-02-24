<?php

function db_insert($table, $array) {
	Global $db;
	$columns = implode(',', array_keys($array));
	$values  = implode(',', array_values($array));
	$query   = "INSERT INTO ".prefix."{$table} ({$columns}) VALUES ({$values})";
	$res = $db->query($query);
	if ( !$res ) {
		throw new Exception($db->error);
	}
	return $db->insert_id;
}

function db_delete($table, $id, $id_col = 'id') {
	Global $db;
	$query   = "DELETE FROM ".prefix."{$table} WHERE {$id_col} = '{$id}'";
	$res = $db->query($query);
	if ( !$res ) {
		throw new Exception($db->error);
	}
	return $res;
}

function db_update($table, $array, $id, $id_col = 'id') {
	Global $db;
	$columns = array_keys($array);
	$values  = array_values($array);
	$count   = count($columns);

	$update  = '';
	for($i=0;$i<$count;$i++)
		$update .= "{$columns[$i]} = {$values[$i]}" . ($count == $i+1 ? '' : ', ');

	$query   = "UPDATE ".prefix."{$table} SET {$update} WHERE {$id_col} = '{$id}'";
	$res = $db->query($query);
	if ( !$res ) {
		throw new Exception($db->error);
	}
	return $res;
}

function db_count($table, $count = 'id'){
	global $db;
	$sql = $db->query("SELECT COUNT({$count}) FROM ".prefix."{$table}");
	$rs  = $sql->fetch_row();
	$sql->close();
	return $rs[0];
}

function db_get($table, $field, $id, $where='id', $other=false){
	global $db;
	$sql = $db->query("SELECT {$field} FROM ".prefix."{$table} WHERE {$where} = '{$id}' {$other}");
	if (!$sql) {
		throw new Exception($db->error);
		return;
	}
	if($sql->num_rows > 0){
		if (preg_match('/,|\*/', $field)) {
			$res = $sql->fetch_assoc();
			$sql->close();
			return $res;
		}
		$rs = $sql->fetch_row();
		$sql->close();
		return $rs[0];
	}
}

function db_rows($table, $field = 'id'){
	global $db;
	$sql = $db->query("SELECT {$field} FROM ".prefix."{$table}");
	$rs  = $sql->num_rows;
	$sql->close();
	return $rs;
}

function db_mail($to, $from_user, $from_email, $subject = '(No subject)', $message = ''){
	$from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
	$subject   = "=?UTF-8?B?".base64_encode($subject)."?=";

	$headers   = "From: {$from_user} <{$from_email}>\r\n".
                 "MIME-Version: 1.0" . "\r\n" .
                 "Content-type: text/html; charset=UTF-8" . "\r\n";

	return mail($to, $subject, $message, $headers,"-f {$from_email}");
}

function db_break($data){
	return preg_replace( '#(\\\r\\\n)#', '<br/>', nl2br($data) );
}

function db_findurl($data){
	return preg_replace(
              "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
              "<a href=\"\\0\" target=\"_blank\">\\0</a>",
              $data);
}

function db_select($data) {
	Global $db;
	$data['column'] = isset($data['column']) ? $data['column'] : '*';
	$data['join']   = isset($data['join'])   ? "LEFT JOIN ".prefix.$data['join'] : '';
	$data['where']  = isset($data['where'])  ? "WHERE ".$data['where'] : '';
	$data['order']  = isset($data['order'])  ? $data['order'] : '';
	$sql = $db->query( "SELECT {$data['column']} FROM ".prefix."{$data['table']} {$data['join']} {$data['where']} {$data['order']}" );
	return $sql;
}
