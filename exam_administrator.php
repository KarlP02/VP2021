<?php
    require_once("../../config.php");
    require_once("exam_fnc_register.php");

    $list_html = null;
    $list_html = show_user_data();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title>Administraator</title>
</head>
<body>
    <h1>Peole registreerinud inimesed</h1>
    <hr>
    <?php echo $list_html;?>
</body>
</html>