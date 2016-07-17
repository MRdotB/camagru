<?php
include 'app/Router.class.php';
include 'app/User.class.php';

session_start();
// basic test
//Users
Router::post('/user/register', function() {
	$data = [
		'username' => $_POST['username'],
		'email' => $_POST['email'],
		'password' => $_POST['password']
	];

	$user = new User();
	$user->register($data);
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
		echo 'error';
	}

});
Router::get('/user/logout', function() {

});

Router::get('/', function() {
	echo 'Get to /';
	$data = [
		'username' => 'baptiste',
		'email' => 'baptiste.chaleil@gmail.com',
		'password' => 'Onizuka75'
	];
	$user->register($data);
});

Router::post('/login', function() {
	print_r($_POST);
	echo 'Post to /login';
});

Router::put('/', function() {
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
	parse_str(file_get_contents("php://input"), $_PUT);

	foreach ($_PUT as $key => $value)
	{
		unset($_PUT[$key]);

		$_PUT[str_replace('amp;', '', $key)] = $value;
	}

	$_REQUEST = array_merge($_REQUEST, $_PUT);
}
	print_r($_PUT);
	echo 'Put to /';
});

Router::patch('/', function() {
	echo 'Patch to /';
});

Router::delete('/', function() {
	echo 'Delete to /';
});

Router::get('/images/:id', function($id) {
	echo 'The slug is: ' . $id;
});


Router::dispatch();
//echo '<br>';
//Router::debug();
