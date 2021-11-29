<?php
    $database = "if21_karl_pii";

    function store_user_data($firstname, $lastname, $studentcode){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
        $stmt = $conn->prepare("INSERT INTO vp_party (firstname, lastname, studentcode) VALUES(?,?,?)");
        echo $conn->error;
        $stmt->bind_param("ssi", $firstname, $lastname, $studentcode);
        if($stmt->execute()){
            $notice = "Registreerimine õnnestus!";
        } else {
            $notice = "Registreerimisel tekkis tõrge!";
        }

        $stmt->close();
        $conn->close();
        return $notice;
    }

    function show_user_data(){
        $list_html = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT firstname, lastname, studentcode, payment, cancelled FROM vp_party");
        echo $conn->error;
        $stmt->bind_result($firstname_from_db, $lastname_from_db, $studentcode_from_db, $payment_from_db, $cancelled_from_db);
        $stmt->execute();
        while($stmt->fetch()){
            $list_html .= '<p>' .$studentcode_from_db ." " .$firstname_from_db ." " .$lastname_from_db ." " .'';
            if($payment_from_db != NULL){
                $payment_from_db = "makstud";
            } else {
                $payment_from_db = "maksmata";
            }
            $list_html .= '' ."MAKSU STAATUS: " .$payment_from_db ." " .'';
            if($cancelled_from_db != NULL){
                $cancelled_from_db = "tühistatud";
            } else {
                $cancelled_from_db = "osaleb";
            }
            $list_html .= '' ."OSAVÕTU STAATUS: " .$cancelled_from_db .'</p>' ."\n";
        }

        $stmt->close();
        $conn->close();
        return $list_html;
    }

    function user_change_part($studentcode_cancel){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
        $stmt = $conn->prepare("UPDATE vp_party SET cancelled = NOW() WHERE studentcode = ?");
        echo $conn->error;
        $stmt->bind_param("i", $studentcode_cancel);
        if($stmt->execute()){
            $notice = "Osalemise staatus on muudetud!";
        } else {
            $notice = "Osalemise staatuse muutmisel tekkis tõrge!";
        }

        $stmt->close();
        $conn->close();
        return $notice;
    }