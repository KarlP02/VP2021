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
	
    require_once("../../config.php");
	require_once("fnc_gallery.php");

	if(isset($_GET["photo"]) and !empty($_GET["photo"])){
		//loeme pildi ja teeme vormi, kuhu loome pildi andmed
	} else {
		//tagasi eelmisena vaadatud lehele
		header("Location: home.php");
	}

    require("page_header.php");
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
    <ul>
		<li><a href="gallery_own.php">Tagasi</a></li>
        <li><a href="?logout=1">Logi välja</a></li>
    </ul>
	<hr>
    <h2>Foto andmete muutmine</h2>
    <?php echo edit_own_photos($photo_id); ?>
</body>
</html>