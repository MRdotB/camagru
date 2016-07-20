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
				<div id="collection" class="gallery--block">
				<?php 
					$i = 0;
					foreach($images as $image) {
						if (++$i > 3) {
							echo '<div class="gallery--modifier gallery--elem"><img data-id="' . $image['id'].'" src="' . $image['path'] . '"/></div>';
						} else {
							echo '<div class="gallery--elem"><img data-id="' . $image['id'].'" src="' . $image['path'] . '"/></div>';
						}
					}
							?>
				</div>
				<?php>
					$pagination = ceil(count($images) / 3);
					echo '<ul id="pagination"><li class="disabled"><a><i class="material-icons">chevron_left</i></a></li>';
					for($i = 0; $i < $pagination; $i++) {
						echo '<li><a>' . $i . '</a></li>';
					}
					echo '<li class="disabled"><a><i class="material-icons">chevron_right</i></a></li></ul>';
				?>
				<div>
				</div>
			</article>
		</div>
		 <footer>footer</footer>
		<script src="/public/js/gallery.js"></script>
	</body>
</html>
