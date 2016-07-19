<?php
require_once('Database.trait.php');

Class Image {
	use Database;

	private $db;

	public function __construct() {
		$this->db = $this->connect();
	}
	public function get_images() {
		try {
			$stmt = $this->db->prepare("SELECT * FROM Images ORDER BY id DESC");
			$stmt->bindparam(':user_id', $_SESSION['id']);
			$stmt->execute(); 
			$images = $stmt->fetchAll();
			return $images;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_user_image() {
		try {
			$stmt = $this->db->prepare("SELECT path, id FROM Images WHERE user_id=:user_id ORDER BY id DESC");
			$stmt->bindparam(':user_id', $_SESSION['id']);
			$stmt->execute(); 
			$images = $stmt->fetchAll();
			return $images;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function delete_image($id) {
		try {
			$stmt = $this->db->prepare("SELECT path FROM Images WHERE id=:id AND user_id=:user_id LIMIT 1");
			$stmt->bindparam(':user_id', $_SESSION['id']);
			$stmt->bindparam(':id', $id);
			$stmt->execute(); 
			$img = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!$img) {
				return false;
			}
			unlink($img['path']);
			$stmt = $this->db->prepare("DELETE from Images WHERE id=:id AND user_id=:user_id");
			$stmt->bindparam(':user_id', $_SESSION['id']);
			$stmt->bindparam(':id', $id);
			$stmt->execute(); 
			return true;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	private function save_image($path) {
		try {
			$stmt = $this->db->prepare("INSERT INTO Images(path, user_id) VALUES(:path, :user_id)");
			$stmt->bindparam(':path', $path);
			$stmt->bindparam(':user_id', $_SESSION['id']);
			$stmt->execute(); 
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function montage($data) {
		if ($data['sunglass'] == false && $data['join'] == false) {
			return false;
		}
		foreach ($_FILES["pictures"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$tmp_name = $_FILES["pictures"]["tmp_name"][$key];
				$name = $_FILES["pictures"]["name"][$key];
				$t = imagecreatefrompng($tmp_name);
				imagealphablending($t, true);
				imagesavealpha($t, true);
				if ($data['sunglass'] === 'true') {
					$sunglasses = imagecreatefrompng('public/img/thugsunglasses.png');
					imagecopyresampled($t, $sunglasses, 270, 110, 0, 0, 200, 40, 200, 40);
					imagedestroy($sunglasses);
				}
				if ($data['join'] === 'true') {
					$join = imagecreatefrompng('public/img/thugjoin.png');
					imagecopyresampled($t, $join, 380, 230, 0, 0, 100, 81, 100, 81);
					imagedestroy($join);
				}
				$path = 'public/uploads/img_' . date('Y-m-d-H-i-s') . '_' . uniqid() . '.png';
				imagepng($t, $path);
				$this->save_image($path);
				imagedestroy($t);
				return $path;
			}
		}
	}
}
