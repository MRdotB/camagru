<?php
include 'Database.trait.php';

class User {
	use Database;

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
			$stmt = $this->db->prepare("INSERT INTO Users(username ,email, password)
				VALUES(:username, :email, :password)");
			$stmt->bindparam(':username', $data['username']);
			$stmt->bindparam(':email', $data['email']);
			$stmt->bindparam(':password', $data['password']);
			$stmt->execute(); 
			return true;
		} catch(PDOException $e) {
			echo $e->getMessage();
			return false;
		} 
	}

	public function login($data) {
		try {
			$stmt = $this->db->prepare("SELECT * from Users WHERE username=:username LIMIT 1");
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

	public function reset_password($data) {

	}

}
