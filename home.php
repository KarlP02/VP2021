<?php
	//alustame sessiooni
	session_start();
	//kas on sisselogitud
	if(!isset($_SESSION["user_id"])){
		header("Location: page.php");
	}
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
	}

	require("page_header.php");
?>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<div>
		<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	</div>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate Instituudis</a>.</p>
	<hr>
	<ul>
		<li><a href="list_films.php">Eesti filmide nimekiri</a></li>
		<li><a href="add_films.php">Lisa filme</a></li>
		<li><a href="user_profile.php">Kasutajaprofiil</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	<hr>
</body>
</html>