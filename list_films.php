<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: page.php");
	}
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
	}

	$author_name = "Karl Piiber";
	require_once("../../config.php");
	//echo $server_host;
	require_once("fnc_film.php");
	require_once("fnc_general.php");
	$films_html = null;
	$films_html = read_all_films();

	require("page_header.php");
?>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<div>
		<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	</div>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate Instituudis</a>.</p>
	<hr>
	<ul>
		<li><a href="home.php">Tagasi</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	<hr>
	<h2>Eesti filmid</h2>
	<?php echo $films_html;?>
</body>
</html>