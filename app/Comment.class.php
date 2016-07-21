<?php
require_once('Database.trait.php');

Class Comment {
	use Database, Mail;

	private $db;

	public function __construct() {
		$this->db = $this->connect();
	}

	public function get_comment($img_id) {
		try {
			$stmt = $this->db->prepare("SELECT title, text, username FROM Comments JOIN Users ON user_id WHERE image_id=:img_id ORDER BY date;");
			$stmt->bindparam(':img_id', $img_id);
			$stmt->execute(); 
			$comments = $stmt->fetchAll();
			return $comments;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	// send mail to image owner
	public function insert_comment($data) {
		try {
			$stmt = $this->db->prepare("INSERT INTO Comments (title, text, image_id, user_id, date) VALUES (:title, :text, :image_id, :user_id, CURDATE());");
			$a = htmlentities($data['title']);
			$b = htmlentities($data['text']);
			$stmt->bindparam(':title', $a);
			$stmt->bindparam(':text', $b);
			$stmt->bindparam(':image_id', $data['image_id']);
			$stmt->bindparam(':user_id', $_SESSION['id']);
			$stmt->execute(); 
			$stmt = $this->db->prepare("SELECT email FROM Images JOIN Users ON Images.user_id=Users.id WHERE Images.id=:img_id;");
			$stmt->bindparam(':img_id', $data['image_id']);
			$stmt->execute(); 
			$mail = $stmt->fetch(PDO::FETCH_ASSOC);
			$message = 'Vous avez un nouveau commentaire ! <a href="http://localhost:8080/gallery/'. $data['image_id'] .'">Lien</a>';
			$this->send_mail($mail['email'], "Nouveau commentaire !", $message);

			return $_SESSION['username'];;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

}
