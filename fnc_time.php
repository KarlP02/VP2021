<?php
    $database = "if21_karl_pii";

    function estonian_time($birth_date_from_db){
		$else_time = new DateTime($birth_date_from_db);
		$est_time = $else_time->format("d-m-Y");

		return $est_time;
	}

    function hours_and_minutes($duration_from_db){
        $hours = floor($duration_from_db / 60);
        $minutes = $duration_from_db % 60;
        $time = $hours ."h" ." " .$minutes ."min";

        return $time;
    }