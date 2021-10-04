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
	if(isset($_GET["list_films"])){
		header("Location: list_films.php");
	}
	if(isset($_GET["add_films"])){
		header("Location: add_films.php");
	}

?>
<!DOCTYPE html>
<html lang="et">
	<head>
		<meta charset="utf-8">
		<title><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</title>
	</head>
	<body>
		<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
		<div>
			<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
		</div>
		<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate Instituudis</a>.</p>
		<hr>
		<ul>
			<li><a href="?list_films=1">Eesti filmide nimekiri</a></li>
			<li><a href="?add_films=1">Lisa filme</a></li>
			<li><a href="?logout=1">Logi välja</a></li>
		</ul>
		
	</body>
</html>