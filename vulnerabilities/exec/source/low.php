<?php

if( isset( $_POST[ 'Submit' ] ) ) {
    // Get input and validate strictly - only allow valid IP addresses
    $target = stripslashes( $_POST[ 'ip' ] );

    if( !filter_var( $target, FILTER_VALIDATE_IP ) ) {
        $html .= '<pre>Invalid IP address.</pre>';
    } else {
        // Safe: use escapeshellarg to prevent command injection
        $cmd = shell_exec( 'ping -c 4 ' . escapeshellarg( $target ) );
        $html .= "<pre>{$cmd}</pre>";
    }
}

?>
