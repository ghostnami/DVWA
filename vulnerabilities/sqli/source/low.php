<?php

if( isset( $_REQUEST[ 'Submit' ] ) ) {
    // Get input — VULNERABILITY: no parameterization
    $id = $_REQUEST[ 'id' ];

    switch ($_DVWA['SQLI_DB']) {
        case MYSQL:
            // VULNERABILITY: raw string interpolation into SQL — classic SQLi
            // Attacker can inject: ' OR '1'='1 to dump all users
            // Or: ' UNION SELECT user,password FROM users--
            $query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id';";
            $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

            // Get results
            while( $row = mysqli_fetch_assoc( $result ) ) {
                // Get values
                $first = $row["first_name"];
                $last  = $row["last_name"];

                // Feedback for end user
                $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
            }

            mysqli_close($GLOBALS["___mysqli_ston"]);
            break;
        case SQLITE:
            global $sqlite_db_connection;

            // VULNERABILITY: same raw interpolation on SQLite
            $query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id';";
            $results = $sqlite_db_connection->query($query);
            while( $row = $results->fetchArray() ) {
                $html .= "<pre>ID: {$id}<br />First name: {$row['first_name']}<br />Surname: {$row['last_name']}</pre>";
            }
            break;
    }
}

// Fix: use parameterized queries with prepared statements
// $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE user_id = ?");
// $stmt->bind_param("s", $id);

?>
