<?php
session_start();
// ini_set("auto_detect_line_endings", true);
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
//error_reporting(0);
ini_set('log_errors', 1);

# Connecting to Database
include __DIR__.'/connection.php';
include __DIR__.'/func.sec.php';
include __DIR__.'/func.db.php';

$username = (isset($_SESSION['username'])) ? $_SESSION['username'] : '';
$name     = (isset($_SESSION['name']))     ? $_SESSION['name']     : '';
$public   = (isset($_SESSION['public']))   ? $_SESSION['public']   : '';

$pg = (isset($_GET['pg'])) ? sc_sec($_GET['pg']) : '';
$vp = (isset($_SESSION['vpass'])) ? (int)($_SESSION['vpass']) : 0;
$lg = (isset($_SESSION['login'])) ? (int)($_SESSION['login']) : 0;
$id = $lg;

// the code below ensures that if user is not logged in, they can't access any other page and get redirected to index
if (isset($LOGIN_REQ_OVERRIDE) && $LOGIN_REQ_OVERRIDE == true) {
	// don't redirect if we're on impact (tree) pages, users can set public or private if they want
} else {
    $whitelist = array("/", "/register", "/ajax.php?pg=login-send", "/ajax.php?pg=vpass-send", "/ajax.php?pg=user-send", "/impact.php");

    if (!$lg && !in_array($_SERVER['REQUEST_URI'], $whitelist)) {
        // redirect if user is not logged in
        header('Location: /');
    }
}
