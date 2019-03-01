<?php

function strip_tags_content($text, $tags = '', $invert = FALSE){
    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);

    if(is_array($tags) AND count($tags) > 0) {
        if($invert == FALSE) {
            return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        } else {
            return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
        }
    } elseif($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    return $text;
}

function sc_sec($data, $html = false) {
	global $db;
	$post = $db->real_escape_string($data);
	$post = trim($post);
	$post = ($html) ? htmlspecialchars($post) : htmlspecialchars(strip_tags_content($post));
	return $post;
}

function sc_pass($data) {
	//return md5(sha1(md5(sha1($data))));
  return password_hash($data, PASSWORD_DEFAULT);
}

function sc_dehash($hash, $data)
{
  return password_verify($data, $hash);
}


function check_email($email){
	$address = strtolower(trim($email));
	return (preg_match("/^[a-zA-Z0-9_.-]{1,40}+@([a-zA-Z0-9_-]){2,30}+\.([a-zA-Z0-9.]){2,20}$/i",$address));
}



function fh_alerts($alert, $type = 'danger', $html = true) {
	global $lang;
  switch($type){
    case 'danger':  $title = 'Oh snap!'; break;
    case 'success': $title = 'Well done!'; break;
    case 'info':    $title = 'Heads up!'; break;
    case 'warning': $title = 'Warning!'; break;
  }

	$title = $lang['alerts'][$type];

  return ($html) ? '<div class="alert alert-'.$type.'">
            <strong>'.$title.'</strong> '.$alert.'
          </div>' : '<strong>'.$title.'</strong> '.$alert;
}
