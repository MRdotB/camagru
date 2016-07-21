<header>
	<div class="rack">
		<a id="logo" href="http://localhost:8080"><h1>Camagru</h1></a>
		<a class="nav" href="/gallery">gallery</a>
		<a <?php if(isset($_SESSION['username'])) echo "class='hide'" ;?> class="nav" href="/login">login</a>
		<a <?php if(!isset($_SESSION['username'])) echo "class='hide'" ;?>class="nav" href="/user/logout">logout</a>
	</div>
</header>
