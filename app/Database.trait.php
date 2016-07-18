<?php
trait Database {
	private function connect() {
		include 'config/database.php';

		try {
			$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbh;
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			die();
		}
	}
}
