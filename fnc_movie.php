<?php
    $database = "if21_karl_pii";

    function read_all_person($selected){
        $html = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        //<option value="x" selected>Eesnimi Perekonnanimi</option>
        $stmt = $conn->prepare("SELECT id, first_name, last_name, birth_date FROM person");
        $stmt->bind_result($id_from_db, $first_name_from_db, $last_name_from_db, $birth_date_from_db);
        $stmt->execute();
        while($stmt->fetch()){
            $html .= '<option value="' .$id_from_db .'"';
            if($selected == $id_from_db){
                $html .= " $selected";
            }
            $html .= ">" .$first_name_from_db ." " .$last_name_from_db ." (" .$birth_date_from_db .")</option> \n";
        }
        $stmt->close();
        $conn->close();
        return $html;
    }

    function read_all_movie($selected){
        $html = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, title, production_year FROM movie");
        $stmt->bind_result($id_from_db, $title_from_db, $production_year_from_db);
        $stmt->execute();
        while($stmt->fetch()){
            $html .= '<option value="' .$id_from_db .'"';
            if($selected == $id_from_db){
                $html .= " $selected";
            }
            $html .= ">" .$title_from_db ." (" .$production_year_from_db .")</option> \n";
        }
        $stmt->close();
        $conn->close();
        return $html;
    }

    function read_all_position($selected){
        $html = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, position_name FROM position");
        $stmt->bind_result($id_from_db, $position_name_from_db);
        $stmt->execute();
        while($stmt->fetch()){
            $html .= '<option value="' .$id_from_db .'"';
            if($selected == $id_from_db){
                $html .= " $selected";
            }
            $html .= ">" .$position_name_from_db ."</option> \n";
        }
        $stmt->close();
        $conn->close();
        return $html;
    }

    function read_all_role($selected){
        $html = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, role FROM person_in_movie");
        $stmt->bind_result($id_from_db, $role_from_db);
        $stmt->execute();
        while($stmt->fetch()){
            $html .= '<option value="' .$id_from_db .'"';
            if($selected == $id_from_db){
                $html .= " $selected";
            }
            $html .= ">" .$role_from_db ."</option> \n";
        }
        $stmt->close();
        $conn->close();
        return $html;
    }

    function store_person_in_movie($selected_person, $selected_movie, $selected_position, $role_input){
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("INSERT INTO person_in_movie (person_id, movie_id, position_id, role) VALUES(?,?,?,?)");
        $stmt->bind_param("iiis", $selected_person, $selected_movie, $selected_position, $role_input);
        if($stmt->execute()){
            $success = "Salvestamine ??nnestus!";
        } else {
            $success = "Salvestamisel tekkis viga: " .$stmt->error;
        }

        $stmt->close();
        $conn->close();
        return $success;
    }

    function store_quote($selected_role, $quote_input){
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("INSERT INTO quote (quote_text, person_in_movie_id) VALUES(?,?)");
        $stmt->bind_param("is", $selected_role, $quote_input);
        if($stmt->execute()){
            $success = "Salvestamine ??nnestus!";
        } else {
            $success = "Salvestamisel tekkis viga: " .$stmt->error;
        }

        $stmt->close();
        $conn->close();
        return $success;
    }

    function read_person_name_for_filename($id){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT first_name, last_name FROM person WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($first_name_from_db, $last_name_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            $notice = $first_name_from_db ."_" .$last_name_from_db;
        } else {
            $notice = $id;
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
    
    function store_person_photo($file_name, $person_id){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("INSERT INTO picture (picture_file_name, person_id) VALUES (?, ?)"); 
        $stmt->bind_param("si", $file_name, $person_id);
        if($stmt->execute()){
            $notice = "Uus foto edukalt salvestatud!";
        } else {
            $notice = "Uue foto andmebaasi salvestamisel tekkis viga: " .$stmt->error;
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
?>