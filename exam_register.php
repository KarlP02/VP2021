<?php
    require_once("../../config.php");
    require_once("exam_fnc_register.php");
    require_once("fnc_general.php");

    $register_notice = null;
    $cancel_notice = null;

    $firstname = null;
    $lastname = null;
    $studentcode = null;
    $studentcode_cancel = null;

    $firstname_error = null;
    $lastname_error = null;
    $studentcode_error = null;
    $studentcode_cancel_error = null;

    if(isset($_POST["register_submit"])){
        if(!empty($_POST["firstname_input"])){
            $firstname = test_input(filter_var($_POST["firstname_input"], FILTER_SANITIZE_STRING));
        } else {
            $firstname_error = "Nime sisestamisel tekkis tõrge!";
        }
        if(!empty($_POST["lastname_input"])){
            $lastname = test_input(filter_var($_POST["lastname_input"], FILTER_SANITIZE_STRING));
        } else {
            $lastname_error = "Perekonnanime sisestamisel tekkis tõrge!";
        }
        if(!empty($_POST["studentcode_input"])){
            if(strlen($_POST["studentcode_input"]) == 6){
                $studentcode = filter_var($_POST["studentcode_input"], FILTER_VALIDATE_INT);    
            }
        } else {
            $studentcode_error = "Üliõpilaskoodi sisestamisel tekkis tõrge!";
        }

        if(empty($firstname_error) and empty($lastname_error) and empty($studentcode_error)){
            $register_notice = store_user_data($firstname, $lastname, $studentcode);
        } else {
            $register_notice = "Osa andmeid on puudu!";
        }

        if($_POST["firstname_input"] == "adminadmin"){
            header("Location: exam_administrator.php");
        }
    }

    if(isset($_POST["cancel_submit"])){
        if(!empty($_POST["studentcode_cancel_input"])){
            if(strlen($_POST["studentcode_cancel_input"]) == 6){
                $studentcode_cancel = filter_var($_POST["studentcode_cancel_input"], FILTER_VALIDATE_INT);    
            }
        } else {
            $studentcode_cancel_error = "Üliõpilaskoodi sisestamisel tekkis tõrge!";
        }

        if(empty($studentcode_cancel_error)){
            $cancel_notice = user_change_part($studentcode_cancel);
        } else {
            $cancel_notice = "Üliõpilaskood on puudu!";
        }
    }
    

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title>Registreerimine</title>
</head>
<body>
    <h1>Peole registreerimine</h1>
    <hr>
    <p>Peole registreerimiseks, palun täitke järgmine form!</p>
    <hr>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="firstname_input">Sisestage oma eesnimi:</label>
        <br>
        <input type="text" name="firstname_input" id="firstname_input" placeholder="eesnimi"><span><?php echo $firstname_error;?></span>
        <br>
        <label for="lastname_input">Sisestage oma perekonnanimi:</label>
        <br>
        <input type="text" name="lastname_input" id="lastname_input" placeholder="perekonnanimi"><span><?php echo $lastname_error;?></span>
        <br>
        <label for="studentcode_input">Sisestage oma üliõpilaskood:</label>
        <br>
        <input type="number" name="studentcode_input" id="studentcode_input" min="1" placeholder="üliõpilaskood"><span><?php echo $studentcode_error;?></span>
        <br>
        <input type="submit" name="register_submit" id="register_submit" value="Saada ära">
    </form>
    <hr>
    <p>Registreerimise tühistamiseks, palun täitke järgmine form!</p>
    <hr>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="studentcode_input">Sisestage oma üliõpilaskood:</label>
        <br>
        <input type="number" name="studentcode_cancel_input" id="studentcode_cancel_input" min="1" placeholder="üliõpilaskood"><span><?php echo $studentcode_cancel_error;?></span>
        <br>
        <input type="submit" name="cancel_submit" id="cancel_submit" value="Tühista ära">
    </form>
    <span><?php echo $register_notice; ?></span>
    <span><?php echo $cancel_notice; ?></span>
</body>
</html>