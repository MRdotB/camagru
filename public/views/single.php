<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="/public/css/css.css">
		<title>Camagru</title>
	</head>
	<body>
		<?php include('public/views/header.php');?>
		<div id='main'>
			<article id="article">
				<?php
					echo '<img data-id="' . $img['id'] . '" src="/' . $img['path'] . '"/>';
				?>
			<div id="count"></div>
			<div <?php if(!isset($_SESSION['username'])) echo "class='hide'" ;?> id="like">Like</div>
			<div <?php if(!isset($_SESSION['username'])) echo "class='hide'" ;?> id="unlike">Unlike</div>
			<div id="comments"
			<?php if(!isset($_SESSION['username'])) echo "class='hide'" ;?>>
				<ul>
				<?php
					foreach ($comments as $c) {
						echo '<li>' . $c['title'] . '</li>';
						echo '<li>' . $c['text']. '</li>';
						echo '<li>' . $c['username']. '</li>';
					}
				?>
				</ul>
					titre: <br/><input type="text" id="title"/><br/>
					<textarea id="text" rows="4" cols="50"></textarea><br>
					<button id="submit">Commenter</button>
			</div>
			</article>
		</div>
		 <footer>bchaleil</footer>
		<script src="/public/js/like.js"></script>
		<script src="/public/js/comment.js"></script>
	</body>
</html>
