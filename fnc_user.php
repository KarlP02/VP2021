<?php
    $database = "if21_karl_pii";

    function store_new_user($name, $surname, $gender, $birth_date, $email, $password){
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("INSERT INTO vp_users (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
        echo $conn->error;
        //krüpteerime parooli
        $option = ["cost" => 12];
        $pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option);

        $stmt->bind_param("sssiss", $name, $surname, $birth_date, $gender, $email, $pwd_hash);
        $notice = null;
        if($stmt->execute()){
            $notice = "Uus kasutaja edukalt loodud!";
        } else {
            $notice = "Uue kasutaja loomisel tekkis viga!" .$stmt->error;
        }

        $stmt->close();
        $conn->close();
        return $notice;
    }

    function sign_in($email, $password){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM vp_users WHERE email = ?");
        echo $conn->error;
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db, $password_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            //tuli vaste, kontrollime paroooli
            if(password_verify($password, $password_from_db)){
                //sisse logimine
                $_SESSION["user_id"] = $id_from_db;
                $_SESSION["first_name"] = $firstname_from_db;
                $_SESSION["last_name"] = $lastname_from_db;
                //kui loeme ka kasutajaprofiili, siis saame teksti ja taustavärvi
                $stmt->close();
                //loeks kasutajaprofiili, kus on selle kasutaja id
                $stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vp_userprofiles WHERE userid = ?");
                $stmt->bind_param("i", $_SESSION["user_id"]);
                $stmt->bind_result($bg_color, $text_color);
                $stmt->execute();
                if($stmt->fetch()){
                    $_SESSION["text_color"] = $text_color;
                    $_SESSION["bg_color"] = $bg_color;
                } else {
                    $_SESSION["text_color"] = "#000000";
                    $_SESSION["bg_color"] = "#FFFFFF";
                }
                
                $stmt->close();
                $conn->close();
                header("Location: home.php");
                exit();
                
            } else {
                $notice = "Kasutajanimi või parool on vale!";
            }
        } else {
            $notice = "Kasutajanimi või parool on vale!";
        }

        $stmt->close();
        $conn->close();
        return $notice;
    }

    function store_user_settings($description, $bg_color, $text_color){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("INSERT INTO vp_userprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
        echo $conn->error;
        $stmt->bind_param("ssss", $_SESSION["user_id"], $description, $bg_color, $text_color);
        if($stmt->execute()){
            $notice = "Uued andmed salvestati!";
        } else {
            $notice = "Tekkis viga!" .$stmt->error;
        }

        $stmt->close();
        $conn->close();
        return $notice;
    }