<?php
include 'app/Router.class.php';
include 'app/User.class.php';
include 'app/Image.class.php';

session_start();
// Views
Router::get('/', function() {
	$image = new Image();
	$images = $image->get_user_image();
	include('public/views/home.php');
});
Router::get('/gallery', function() {
	$image = new Image();
	$images = $image->get_images();
	include('public/views/gallery.php');
});
Router::get('/login', function() {
	echo 'home';
});
Router::get('/register', function() {
	echo 'home';
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
		echo 'register';
	} else {
		echo 'FAIL register';
	}
});
Router::get('/user/verify/:id', function($id) {
	$data = [
		'verif_link' => $id,
		];

	$user = new User();
	if ($user->verify($data)) {
		echo 'verify';
	} else {
		echo 'FAIL verify';
	}
});
Router::post('/user/login', function() {
	$data = [
		'username' => $_POST['username'],
		'password' => $_POST['password']
		];

	$user = new User();
	if ($user->login($data)) {
		echo 'logged';
	} else {
		echo 'FAIL';
	}
});
Router::post('/user/reset/:any', function($name) {
	$data = [
		'username' => $name
		];

	$user = new User();
	if ($user->reset_password_send($data)) {
		echo 'reset';
	} else {
		echo 'FAIL';
	}
});
Router::get('/user/reset/:id', function($id) {
	$data = [
		'verif_password' => $id
		];

	$user = new User();
	if ($user->reset_password($data)) {
		echo 'reset';
	} else {
		echo 'FAIL';
	}
});
Router::get('/user/logout', function() {
	$user = new User();
	$user->logout();
	echo 'logout';
});

//Images
Router::post('/image/upload', function() {
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
	$image = new Image();
	header('Content-Type: application/json');
	if ($result = $image->delete_image($id)) {
		echo 'true';
		//echo json_encode(['' => 'message d\'erreur lol.']);
	} else {
		echo 'false';
	}
});


//Router::debug();
Router::dispatch();
