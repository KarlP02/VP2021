<?php
	$author_name = "Karl Piiber";
	require_once("../../config.php");
	//echo $server_host;
	require_once("fnc_film.php");

	$film_store_notice = null;

	$title_missing = null;
	$year_missing = null;
	$duration_missing = null;
	$genre_missing = null;
	$studio_missing = null;
	$director_missing = null;

	$title = null;
	$year = null;
	$duration = null;
	$genre = null;
	$studio = null;
	$director = null;
	
	//kas püütakse salvestada
	if(isset($_POST["film_submit"])){

		//kontrollin, et andmeid ikka sisestati
		if(!empty($_POST["title_input"]) and !empty($_POST["year_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["studio_input"]) and !empty($_POST["director_input"])){
			$film_store_notice = store_film($_POST["title_input"], $_POST["year_input"], $_POST["duration_input"], $_POST["genre_input"], $_POST["studio_input"], $_POST["director_input"]);
		} else {
			$film_store_notice = "Osa andmeid on puudu!";
		}
		if(empty($_POST["title_input"])){
			$title_missing = "Pealkiri on puudu!";
		} else {
			$title = $_POST["title_input"];
		}
		if(empty($_POST["year_input"])){
			$year_missing = "Valmimisaasta on puudu!";
		} else {
			$year = $_POST["year_input"];
		}
		if(empty($_POST["genre_input"])){
			$genre_missing = "Žanr on puudu!";
		} else {
			$genre = $_POST["genre_input"];
		}
		if(empty($_POST["studio_input"])){
			$studio_missing = "Tootja on puudu!";
		} else {
			$studio = $_POST["studio_input"];
		}
		if(empty($_POST["director_input"])){
			$director_missing = "Režissöör on puudu!";
		} else {
			$director = $_POST["director_input"];
		}
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
		<h2>Eesti filmide lisamine andmebaasi</h2>
		<form method="POST">
			<label for="title_input">Filmi pealkiri</label>
			<input type="text" name="title_input" id="title_input" placeholder="Filmi pealkiri" value="<?php echo $title; ?>"> <?php echo $title_missing ?>
			<br>
			<label for="year_input">Valmimisaasta</label>
			<input type="number" name="year_input" id="year_input" min="1912" value="<?php echo $year ?>"> <?php echo $year_missing ?>
			<br>
			<label for="duration_input">Kestus</label>
			<input type="number" name="duration_input" id="duration_input" min="1" max="600" value="60">
			<br>
			<label for="genre_input">Filmi žanr</label>
			<input type="text" name="genre_input" id="genre_input" placeholder="Filmi žanr" value="<?php echo $genre ?>"> <?php echo $genre_missing ?>
			<br>
			<label for="studio_input">Filmi tootja</label>
			<input type="text" name="studio_input" id="studio_input" placeholder="Filmi tootja" value="<?php echo $studio ?>"> <?php echo $studio_missing ?>
			<br>
			<label for="director_input">Filmi režissöör</label>
			<input type="text" name="director_input" id="director_input" placeholder="Filmi režissöör" value="<?php echo $director ?>"> <?php echo $director_missing ?>
			<br>
			<input type="submit" name="film_submit" value="Salvesta">
		</form>
		<span><?php echo $film_store_notice; ?></span>
	</body>
</html>