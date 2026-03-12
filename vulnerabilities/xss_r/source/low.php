<?php

// VULNERABILITY: XSS header disabled, raw GET param echoed without sanitization
header ("X-XSS-Protection: 0");

if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
    // VULNERABILITY: $_GET['name'] echoed directly — reflected XSS
    // Attacker can inject: <script>alert(document.cookie)</script>
    // or: <img src=x onerror=alert(1)>
    $html .= '<pre>Hello ' . $_GET[ 'name' ] . '</pre>';
}

// Fix: use htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8')

?>
