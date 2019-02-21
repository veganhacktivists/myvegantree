<?php

$connect = [
	'HOSTNAME' => 'localhost', // HOST NAME
	'USERNAME' => 'vrdntf_vtreeuser',      // DATABASE USERNAME
	'PASSWORD' => '*cpsess8279904246',      // DATABASE PASSWORD
	'DATABASE' => 'vrdntf_myvegantree_test' // DATABASE NAME
];

$db = new mysqli($connect['HOSTNAME'], $connect['USERNAME'], $connect['PASSWORD'], $connect['DATABASE']);
if($db->connect_errno){
    echo "Echec lors de la connexion à MySQL : (" . $db->connect_errno . ") " . $db->connect_error;
}

# Tables' Prefix
define('prefix', 'mvt_');
