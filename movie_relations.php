<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: page.php");
	}
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
	}

    require_once("../../config.php");
    //echo $server_host;
    require_once("fnc_movie.php");
	require_once("fnc_general.php");

	$notice = null;
	$role = null;
	$selected_person = null;
	$selected_movie = null;
	$selected_position = null;
	$selected_role = null;
	$person_in_movie_error = null;
	$file_name = null;
	$quote_input = null;
	
	$selected_person_for_photo = null;
	$photo_upload_submit = null;
	$photo_upload_notice = null;
	$photo_dir = "movie_photos/";


	if(isset($_POST["person_in_movie_submit"])){
        if(isset($_POST["person_input"]) and !empty($_POST["person_input"])){
            $selected_person = filter_var($_POST["person_input"], FILTER_VALIDATE_INT);
        } else {
            $person_in_movie_error .= "Isik on valimata! "; 
        }
        
        if(isset($_POST["movie_input"]) and !empty($_POST["movie_input"])){
            $selected_movie = filter_var($_POST["movie_input"], FILTER_VALIDATE_INT);
        } else {
            $person_in_movie_error .= "Film on valimata! "; 
        }
        
        if(isset($_POST["position_input"]) and !empty($_POST["position_input"])){
            $selected_position = filter_var($_POST["position_input"], FILTER_VALIDATE_INT);
        } else {
            $person_in_movie_error .= "Amet on valimata! "; 
        }
        
        if($selected_position == 1){
            if(isset($_POST["role_input"]) and !empty($_POST["role_input"])){
                $role = test_input(filter_var($_POST["role_input"], FILTER_SANITIZE_STRING));
                if(empty($role)){
                    $person_in_movie_error .= "Palun sisesta näitlejale normaalne rolli nimi!";
                }
            } else {
                $person_in_movie_error .= "Näitleja roll on sisestamata!";
            }
			
        }
        
        if(empty($person_in_movie_error)){
            $person_in_movie_error = store_person_in_movie($selected_person, $selected_movie, $selected_position, $role);
        }
        
    }

	if(isset($_POST["person_quote_in_movie_submit"])){
		if(isset($_POST["choose_role_input"]) and !empty($_POST["choose_role_input"])){
			$selected_role = filter_var($_POST["choose_role_input"], FILTER_VALIDATE_INT);
		} else {
			$person_in_movie_error .= "Roll on valimata! "; 
		}

		if(isset($_POST["quote_input"]) and !empty($_POST["quote_input"])){
			$quote_input = test_input(filter_var($_POST["quote_input"], FILTER_SANITIZE_STRING));
			if(empty($role)){
				$person_in_movie_error .= "Palun sisesta normaalne tsitaat!";
			}
		} else {
			$person_in_movie_error .= "Tsitaat on sisestamata!";
		}
		
		if(empty($person_in_movie_error)){
            $person_in_movie_error = store_quote($selected_role, $quote_input);
        }
	}
	
	if(isset($_POST["photo_upload_submit"])){
		//var_dump($_POST);
		//var_dump($_FILES);
		$image_check = getimagesize($_FILES["photo_input"]["tmp_name"]);
		if($image_check !== false){
			if($image_check["mime"] == "image/jpeg"){
				$file_type = "jpg";
			}
			if($image_check["mime"] == "image/png"){
				$file_type = "png";
			}
			if($image_check["mime"] == "image/gif"){
				$file_type = "gif";
			}
			//teen ajatempli
			$time_stamp = microtime(1) * 10000;
			//moodustame filinime (kasutaksin ees- ja perekonnanime aga praegu on meil vaid inimese id)
			$file_name = $_POST["person_for_photo_input"] ."_" .$time_stamp ."." .$file_type;
			//kopeerime pildi originaalkujul, originaalnimega vajalikku kataloogi
			move_uploaded_file($_FILES["photo_input"]["tmp_name"], $photo_dir .$file_name);
		}
	}

	require("page_header.php");
?>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<ul>
		<li><a href="home.php">Tagasi</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	<hr>
    <h2>Filmi info seostamine</h2>
	<h3>Film, inimene ja tema roll</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="person_input">Isik: </label>
		<select name="person_input" id="person_input"><option value="" selected disabled>Vali isik</option><?php echo read_all_person($selected_person); ?></select>
		<br>
		<label for="movie_input">Film: </label>
		<select name="movie_input" id="movie_input"><option value="" selected disabled>Vali film</option><?php echo read_all_movie($selected_movie); ?></select>
		<br>
		<label for="position_input">Amet: </label>
		<select name="position_input" id="position_input"><option value="" selected disabled>Vali amet</option><?php echo read_all_position($selected_position); ?></select>
		<br>
		<label for="role_input">Roll: </label>
		<input type="text" name="role_input" id="role_input" placeholder="Tegelase nimi"></input>
		<br>
    	<input type="submit" name="person_in_movie_submit" value="Salvesta">
    </form>
    <span><?php echo $notice; ?></span>
	<hr>
	<h3>Tegelase tsitaat</h3>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="choose_role_input">Roll: </label>
		<select name="choose_role_input" id="choose_role_input"><option value="" selected disabled>Vali roll</option><?php echo read_all_role($selected_role); ?></select>
		<br>
		<label for="quote_input">Tsitaat: </label>
		<input type="text" name="quote_input" id="quote_input" placeholder="Tegelase tsitaat"></input>
		<br>
    	<input type="submit" name="person_quote_in_movie_submit" value="Salvesta">
    </form>
	<hr>
	<h3>Filmi tegelase foto</h3>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	<label for="person_for_photo_input">Isik: </label>
		<select name="person_for_photo_input" id="person_for_photo_input"><option value="" selected disabled>Vali isik</option><?php echo read_all_person($selected_person_for_photo); ?></select>
		<br>
		<label for="photo_input">Vali pildifail</label>
		<input type="file" name="photo_input" id="photo_input">
		<br>
		<input type="submit" name="photo_upload_submit" value="Lae pilt üles">
	</form>
	<span><?php echo $photo_upload_notice; ?></span>
</body>
</html>