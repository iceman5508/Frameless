<?php

/**
 * Redirects the user ti the url provided
 * @param null $location - The url to be redirected to.
 */
function iredirect_to( $location = NULL ) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

/**
 * Sends an email to the address provided
 * @param $To - address is going to be sent to $To
 * @param $subject -  sublect of the email $subject
 * @param $Message - the messgae $Message
 * @param $FromMessage - who is the email from $FromMessage
 * @return bool - true if sent, false if not sent
 */
function isend_mail($To, $subject,$Message, $FromMessage){
    if(mail($To, $subject, $Message, "From:" . $FromMessage)) {
        return true;
    }
    else {
        return false;
    }
}



?>