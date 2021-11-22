<?php
	require_once("use_session.php");

	// testime klassi
	// require_once("classes/Test.class.php");
	// $my_test_object = new Test(33);
	// echo "Avalik muutuja: " .$my_test_object->non_secret_value;
	// echo "Salajane muutuja: " .$my_test_object->secret_value;
	// $my_test_object->multiply();
	// $my_test_object->reveal();
	// unset($my_test_object);

	// küpsiste ehk coolie'de näide
	
	setcookie("vpvisitor", $_SESSION["first_name"] ." " .$_SESSION["last_name"], time() + (86400 * 8), "/~karpii/VP2021/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
	$last_visitor = null;
	if(isset($_COOKIE["vpvisitor"])){
		$last_visitor = "<p>Viimati külastas lehte: " .$_COOKIE["vpvisitor"] .".</p> \n";
	} else {
		$last_visitor = "<p>Küpsiseid ei leitud, viimane külastaja pole teada.</p> \n";
	}

	// küpsise kustutamiseks määratakse talle varasem (enne praegust hetke) aegumine
	
	require("page_header.php");
?>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<div>
		<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	</div>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate Instituudis</a>.</p>
	<hr>
	<?php echo $last_visitor; ?>
	<hr>
	<ul>
		<li><a href="list_films.php">Eesti filmide nimekiri</a></li>
		<li><a href="list_actors.php">Näitlejad ja nende karjäär</a></li>
		<li><a href="add_films.php">Lisa filme</a></li>
		<li><a href="user_profile.php">Kasutajaprofiil</a></li>
		<li><a href="movie_relations.php">Filmi info sidumine</a></li>
		<li><a href="gallery_photo_upload.php">Fotode üleslaadimine</a></li>
		<li><a href="gallery_public.php">Sisselogitud kasutajatete jaoks avalik galerii</a></li>
		<li><a href="gallery_own.php">Minu oma galerii fotod</a></li>
		<li><a href="add_news.php">Uudise lisamine</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	<hr>
</body>
</html>