<?php
include 'app/Router.php';

Router::get('/', function() {
  echo 'home';
});

Router::post('/', function() {
  echo 'home';
});


Router::get('/images/:id', function($slug) {
  echo 'The slug is: ' . $slug;
});


Router::dispatch();
//Router::debug();
