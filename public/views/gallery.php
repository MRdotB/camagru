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
				<div id="collection" class="gallery--block">
				<?php 
					$i = 0;
					foreach($images as $image) {
						if (++$i > 3) {
							echo '<div class="gallery--modifier gallery--elem"><a href="/gallery/' . $image['id'] . '"><img data-id="' . $image['id'].'" src="' . $image['path'] . '"/></a></div>';
						} else {
							echo '<div class="gallery--elem"><a href="/gallery/' . $image['id'] . '"><img data-id="' . $image['id'].'" src="' . $image['path'] . '"/></a></div>';
						}
					}
							?>
				</div>
				<?php
					$pagination = ceil(count($images) / 3);
					echo '<div class="centerb"><ul id="pagination"><li class="disabled"><a><i class="material-icons">←</i></a></li>';
					for($i = 0; $i < $pagination; $i++) {
						echo '<li><a>' . $i . '</a></li>';
					}
					echo '<li class="disabled"><a><i class="material-icons">&rarr;</i></a></li></ul></div>';
				?>
				<div>
				</div>
			</article>
		</div>
		 <footer>bchaleil</footer>
		<script src="/public/js/gallery.js"></script>
	</body>
</html>
