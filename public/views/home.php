<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="public/css/css.css">
		<title>Camagru</title>
	</head>
	<body>
		<?php include('public/views/header.php');?>
		<div id='main'>
			<article id="article">
				<div id="video-container">
					<video id="video"></video>
					<img class="thug sunglass"src="/public/img/thugsunglasses.png"/>
					<img class="thug join"src="/public/img/thugjoin.png"/>
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
						<button style="display:none;" id="upload">Upload</button>
						<label><input type="checkbox" id="sunglasses" value="sunglasses"> Sunglasses</label>
						<label><input type="checkbox" id="join" value="join"> Join</label>
					</div>
				</div>
			</article>
			<aside>
				<h3>Mes images</h3>
				<div id="sidebar">
				<?php 
					foreach($images as $image) {
						echo '<img data-id="' . $image['id'].'" class="thumbnail" src="' . $image['path'] . '"/>';
					}
				?>
				</div>
			</aside>
		</div>
		 <footer>bchaleil</footer>
		<script src="/public/js/main.js"></script>
	</body>
</html>
