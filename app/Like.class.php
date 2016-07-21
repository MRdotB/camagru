<?php
require_once('Database.trait.php');

Class Like {
	use Database;

	private $db;

	public function __construct() {
		$this->db = $this->connect();
	}

	public function like_count($img_id) {
		try {
			$stmt = $this->db->prepare("SELECT COUNT(*) FROM `Like` WHERE image_id=:img_id;");
			$stmt->bindparam(':img_id', $img_id);
			$stmt->execute(); 
			$count = $stmt->fetch(PDO::FETCH_ASSOC);
			return $count['COUNT(*)'];
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function user_status($img_id) {
		try {
			$stmt = $this->db->prepare("SELECT * FROM `Like` WHERE image_id=:image_id LIMIT 1;");
			$stmt->bindparam(':image_id', $img_id);
			$stmt->execute(); 
			if ($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
			return true;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function like($img_id) {
		try {
			$stmt = $this->db->prepare("INSERT INTO `Like` (image_id, user_id) VALUES (:image_id, :user_id);");
			$stmt->bindparam(':image_id', $img_id);
			$stmt->bindparam(':user_id', $_SESSION['id']);
			$stmt->execute(); 
			return true;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function unlike($img_id) {
		try {
			$stmt = $this->db->prepare("DELETE FROM `Like` WHERE image_id=:image_id;");
			$stmt->bindparam(':image_id', $img_id);
			$stmt->execute(); 
			return true;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
}

