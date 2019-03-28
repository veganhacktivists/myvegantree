<?php

$connect = [
	'HOSTNAME' => 'myvegantree.org', // HOST NAME
	'USERNAME' => 'vrdntf_vtreeuser',      // DATABASE USERNAME
	'PASSWORD' => '94&7268imvegan1&785',      // DATABASE PASSWORD
	'DATABASE' => 'vrdntf_myvegantree' // DATABASE NAME
];

$db = new mysqli($connect['HOSTNAME'], $connect['USERNAME'], $connect['PASSWORD'], $connect['DATABASE']);
if($db->connect_errno){
    echo "Echec lors de la connexion à MySQL : (" . $db->connect_errno . ") " . $db->connect_error;
}

# Tables' Prefix
define('prefix', 'mvt_');
