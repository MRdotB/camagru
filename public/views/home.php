<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="public/css/css.css">
		<title>Camagru</title>
	</head>
	<body>
		<header>
			<div class="rack">
				<h1 id="logo">Camagru</h1>
				<div id="action">
					<a href="/profile">Profile</a>
					<a href="/user/logout">logout</a>
				</div>
			</div>
		</header>
		<div id='main'>
			<article id="article">
				<div id="video-container">
					<video id="video"></video>
					<img class="thug sunglass"src="/public/img/thugsunglasses.png"/>
					<img class="thug join"src="/public/img/thugjoin.png"/>
					<!--<img class="thug chaine"src="/public/img/thugchaine.png"/>-->
				</div>
				<div id="canvas-container">
					<canvas id="canvas"></canvas>
					<img class="thug sunglass"src="/public/img/thugsunglasses.png"/>
					<img class="thug join"src="/public/img/thugjoin.png"/>
				</div>
				<div id="actions">
					<div id="step1">
						<label>Uploader votre image:</label>
						<input type="file" id="imageLoader" name="imageLoader"/>
						<button id="webcam">Activer la Webcam</button>
					</div>
					<div id="step2" class="hide">
						<button class="hide" id="shoot">Prendre une photo</button>
						<button id="upload">Upload</button>
						<label><input type="checkbox" id="sunglasses" value="sunglasses"> Sunglasses</label>
						<label><input type="checkbox" id="join" value="join"> Join</label>
						<label><input type="checkbox" id="collier" value="collier"> Collier</label>
					</div>
				</div>
			</article>
			<aside id="sidebar">
				<h3>Mes images</h3>
				<?php 
					foreach($images as $image) {
						echo '<img data-id="' . $image['id'].'" class="thumbnail" src="' . $image['path'] . '"/>';
					}
				?>
			</aside>
		</div>
		 <footer>footer</footer>
		<script src="/public/js/main.js"></script>
	</body>
</html>
