<?php
    $database = "if21_karl_pii";

    function read_all_actors(){
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT first_name, last_name, title, role FROM person JOIN person_in_movie ON person.id = person_in_movie.person_id JOIN movie ON movie.id = person_in_movie.movie_id");
        echo $conn->error;
        $stmt->bind_result($first_name_from_db, $last_name_from_db, $title_from_db, $role_from_db);
        $stmt->execute();
        $films_html = null;
        while($stmt->fetch()){
            $films_html .= "<h3>" .$first_name_from_db ." " .$last_name_from_db ."</h3> \n";
            $films_html .= "<ul> \n";
            $films_html .= "<li>Filmi pealkiri: " .$title_from_db ."</li> \n";
            $films_html .= "<li>Roll: " .$role_from_db ."</li> \n";
            $films_html .= "</ul> \n";
        }
        //sulgeme SQL käasu
        $stmt->close();
        //sulgeme andmebaasiühenduse
        $conn->close();
        return $films_html;
    }

?>