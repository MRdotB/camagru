<?php
include 'app/Router.class.php';
include 'app/User.class.php';
include 'app/Image.class.php';
include 'app/Comment.class.php';
include 'app/Like.class.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
// Views
Router::get('/', function() {
	if (!isset($_SESSION['username'])) {
		header('Location: http://localhost:8080/login');
	}
	$image = new Image();
	$images = $image->get_user_image();
	include('public/views/home.php');
});
Router::get('/gallery', function() {
	$image = new Image();
	$images = $image->get_images();
	include('public/views/gallery.php');
});
Router::get('/gallery/:id', function($id) {
	$image = new Image();
	$img = $image->get_image($id);
	if (!$img) {
		echo '404';
		return;
	}
	$comment = new Comment();
	$comments = $comment->get_comment($id);
	include('public/views/single.php');
});
Router::post('/like/:id', function($id) {
	if (!isset($_SESSION['username'])) {
		header('Location: http://localhost:8080/login');
	}
	$like = new Like();
	echo $like->like($id);
});
Router::post('/unlike/:id', function($id) {
	if (!isset($_SESSION['username'])) {
		header('Location: http://localhost:8080/login');
	}
	$like = new Like();
	echo $like->unlike($id);
});
Router::post('/likecount/:id', function($id) {
	$like = new Like();
	echo $like->like_count($id);
});

Router::get('/login', function() {
	if (isset($_SESSION['username'])) {
		header('Location: http://localhost:8080');
	}
	include('public/views/login.php');
});
Router::get('/register', function() {
	if (isset($_SESSION['username'])) {
		header('Location: http://localhost:8080');
	}
	include('public/views/register.php');
});
Router::get('/forgotten', function() {
	if (isset($_SESSION['username'])) {
		header('Location: http://localhost:8080');
	}
	include('public/views/forgotten.php');
});
//Comments
Router::post('/comment/add', function() {
	if (!isset($_SESSION['username'])) {
		return false;
	}
	$data = [
		'title' => $_POST['title'],
		'text' => $_POST['text'],
		'image_id' => $_POST['image_id']
	];
	$comment = new Comment($data);
	if ($name = $comment->insert_comment($data)) {
		echo $name;
	} else {
		echo 'false';
	}
});
//Users
Router::post('/user/register', function() {
	$data = [
		'username' => $_POST['username'],
		'email' => $_POST['email'],
		'password' => $_POST['password']
		];

	$user = new User();
	if ($user->register($data)) {
		echo 'true';
	} else {
		echo 'false';
	}
});
Router::get('/user/verify/:id', function($id) {
	$data = [
		'verif_link' => $id,
		];

	$user = new User();
	$user->verify($data);
	header('Location: http://localhost:8080/login');
});
Router::post('/user/login', function() {
	$data = [
		'username' => $_POST['username'],
		'password' => $_POST['password']
		];

	$user = new User();
	if ($user->login($data)) {
		echo 'true';
	} else {
		echo 'false';
	}
});
Router::post('/user/reset/:any', function($name) {
	$data = [
		'username' => $name
		];

	$user = new User();
	if ($user->reset_password_send($data)) {
		echo 'true';
	} else {
		echo 'false';
	}
});
Router::get('/user/reset/:id', function($id) {
	$data = [
		'verif_password' => $id
		];

	$user = new User();
	$user->reset_password($data);
	header('Location: http://localhost:8080/login');
});
Router::get('/user/logout', function() {
	$user = new User();
	$user->logout();
	header('Location: http://localhost:8080/login');
});

//Images
Router::post('/image/upload', function() {
	if (!isset($_SESSION['username'])) {
		echo json_encode(['error' => 'true']);
	}
	$data = [
		'sunglass' => $_POST['sunglass'],
		'join' => $_POST['join']
	];
	$image = new Image();
	header('Content-Type: application/json');
	if ($result = $image->montage($data)) {
		echo json_encode(['path' => $result]);
	} else {
		echo json_encode(['error' => 'true']);
	}
});
Router::post('/image/delete/:id', function($id) {
	if (!isset($_SESSION['username'])) {
		echo 'false';
	}
	$image = new Image();
	header('Content-Type: application/json');
	if ($result = $image->delete_image($id)) {
		echo 'true';
	} else {
		echo 'false';
	}
});

Router::dispatch();
