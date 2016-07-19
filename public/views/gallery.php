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
				<div class="gallery--block">
				<?php 
					foreach($images as $image) {
						echo '<div class="gallery--elem"><img data-id="' . $image['id'].'" src="' . $image['path'] . '"/></div>';
					}
				?>
				</div>
			</article>
		</div>
		 <footer>footer</footer>
		<script src="/public/js/main.js"></script>
	</body>
</html>
