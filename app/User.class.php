<?php
include 'Database.trait.php';
include 'Mail.trait.php';

class User {
	use Database, Mail;

	private $db;

	public function __construct() {
		$this->db = $this->connect();
	}

	public function register($data) {
		try {
			if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $data['username'])
				|| !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $data['password'])
				|| !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				echo 'error';
				return ;
			}
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			$verif_link = mt_rand();
			$stmt = $this->db->prepare("INSERT INTO Users(username ,email, password, verif_link)
				VALUES(:username, :email, :password, :verif_link)");
			$stmt->bindparam(':username', $data['username']);
			$stmt->bindparam(':email', $data['email']);
			$stmt->bindparam(':password', $data['password']);
			$stmt->bindparam(':verif_link', $verif_link);
			$stmt->execute(); 
			$message = "Salut " . $data['username'] . "click sur ce lien pour activer ton compte <a href='http://localhost:8080/user/verify/" . $verif_link . "'> Activer son compte</a>";
			$this->send_mail($data['email'], "Activation de compte", $message);
			return true;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		} 
	}

	public function verify($data) {
		try {
			$stmt = $this->db->prepare("SELECT * FROM Users WHERE verif_link=:verif_link AND verify = 0 LIMIT 1");
			$stmt->bindparam(':verif_link', $data['verif_link']);
			$stmt->execute(); 
			$user_row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() > 0) {
				$stmt = $this->db->prepare("UPDATE Users SET verify=1 WHERE verif_link=:verif_link");
				$stmt->bindparam(':verif_link', $data['verif_link']);
				$stmt->execute(); 
				return true;
			}
			return false;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		} 
	}

	public function login($data) {
		try {
			$stmt = $this->db->prepare("SELECT * from Users WHERE username=:username AND verify = 1 LIMIT 1");
			$stmt->bindparam(':username', $data['username']);
			$stmt->execute(); 
			$user_row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() > 0) {
				if (password_verify($data['password'], $user_row['password'])) {
					$_SESSION['id'] = $user_row['id'];
					$_SESSION['username'] = $user_row['username'];
					return true;
				}
				return false;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function logout() {
		session_destroy();
		$_SESSION = [];
		return true;
	}

	private function generate_password() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars), 0, 12);
	}

	public function reset_password_send($data) {
		try {
			$stmt = $this->db->prepare("SELECT * from Users WHERE username=:username AND verify = 1 LIMIT 1");
			$stmt->bindparam(':username', $data['username']);
			$stmt->execute(); 
			$user_row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() > 0) {
				$verif_password = mt_rand();
				$stmt = $this->db->prepare("UPDATE Users SET verif_password=:verif_password WHERE username=:username");
				$stmt->bindparam(':verif_password', $verif_password);
				$stmt->bindparam(':username', $data['username']);
				$stmt->execute(); 
				$message = "Salut " . $user_row['username'] . " click sur ce lien pour reset ton mot de passe <a href='http://localhost:8080/user/reset/" . $verif_password . "'> Reset</a>";
				$this->send_mail($user_row['email'], "Reset mot de passe", $message);
				return true;
			}
			return false;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function reset_password($data) {
		try {
			$stmt = $this->db->prepare("SELECT * from Users WHERE verif_password=:verif_password AND verify = 1 LIMIT 1");
			$stmt->bindparam(':verif_password', $data['verif_password']);
			$stmt->execute(); 
			$user_row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() > 0) {
				$pass = $this->generate_password();
				$stmt = $this->db->prepare("UPDATE Users SET password=:pass, verif_password=0 WHERE verif_password=:verif_password AND verify = 1");
				$hash = password_hash($pass, PASSWORD_DEFAULT);
				$stmt->bindparam(':pass', $hash);
				$stmt->bindparam(':verif_password', $data['verif_password']);
				$stmt->execute(); 
				$message = "Ton mot de passe est maintenant: " . $pass;
				$this->send_mail($user_row['email'], "Reset mot de passe effectif", $message);
				return true;
			}
			return false;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

}
