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

$id = (isset($_GET['id'])) ? (int)($_GET['id']) : 0;
$pg = (isset($_GET['pg'])) ? sc_sec($_GET['pg']) : '';
$lg = (isset($_SESSION['login'])) ? (int)($_SESSION['login']) : 0;
$vp = (isset($_SESSION['vpass'])) ? (int)($_SESSION['vpass']) : 0;


// echo $lg;
