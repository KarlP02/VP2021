<?php
	$author_name = "Karl Piiber";
	require_once("../../config.php");
	//echo $server_host;
	require_once("fnc_film.php");
	$films_html = null;
	$films_html = read_all_films();

	if(!isset($_SESSION["user_id"])){
		header("Location: page.php");
	}
	if(isset($_GET["tagasi_home"])){
		header("Location: home.php");
	}
?>
<!DOCTYPE html>
<html lang="et">
	<head>
		<meta charset="utf-8">
		<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
	</head>
	<body>
		<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
		<div>
			<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
		</div>
		<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate Instituudis</a>.</p>
		<hr>
		<ul>
			<li><a href="?tagasi_home=1">Tagasi</a></li>
		</ul>
		<h2>Eesti filmid</h2>
		<?php echo $films_html;?>
	</body>
</html>