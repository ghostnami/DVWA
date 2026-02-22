<?php

if( isset( $_POST[ "Submit" ] ) ) {
    $target = $_POST[ "ip" ];
    $cmd = shell_exec( "ping -c 4 " . $target );
    $html .= "<pre>{$cmd}</pre>";
}

?>
