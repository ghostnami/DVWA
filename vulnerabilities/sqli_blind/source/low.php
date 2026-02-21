<?php

if( isset( $_GET[ 'Submit' ] ) ) {
    // Get input
    $id = $_GET[ 'id' ];
    $exists = false;

    switch ($_DVWA['SQLI_DB']) {
        case MYSQL:
            // Safe: use prepared statement
            $stmt = $GLOBALS["___mysqli_ston"]->prepare(
                "SELECT first_name, last_name FROM users WHERE user_id = ?"
            );
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $exists = ($result->num_rows > 0);
            $stmt->close();
            break;
        case SQLITE:
            global $sqlite_db_connection;
            $stmt = $sqlite_db_connection->prepare(
                "SELECT first_name, last_name FROM users WHERE user_id = :id"
            );
            $stmt->bindValue(':id', $id, SQLITE3_TEXT);
            $result = $stmt->execute();
            $row = $result->fetchArray();
            $exists = $row !== false;
            break;
    }

    if( $exists ) {
        $html .= '<pre>User ID exists in the database.</pre>';
    } else {
        header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' 404 Not Found' );
        $html .= '<pre>User ID is MISSING from the database.</pre>';
    }
}

?>
