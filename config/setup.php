<?php
include 'database.php';

try {
	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
	die();
}

// Create tables
$create_tables = file_get_contents('config/create_tables.sql');

try {
	$r = $dbh->exec($create_tables);
}
catch (PDOException $e)
{
	echo $e->getMessage($r);
	die();
}
