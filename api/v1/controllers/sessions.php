<?php

require('../../../core/init.php');
require_once('../libraries/Session.php');
require_once('../libraries/Response.php');

?>



<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    sleep(1);

    if ($_SERVER['CONTENT_TYPE'] != 'application/json') {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Header type not set to JSON");
        $response->send();
        exit;
    }

    $rawData = file_get_contents('php://input');

    if (!$jsonData = json_decode($rawData)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Invalid JSON body");
        $response->send();
        exit;
    }

    if (!isset($jsonData->userId)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("User ID required to create a session");
        $response->send();
        exit;
    }

    $username = isset($jsonData->username) ? $jsonData->username : null;
    $email = isset($jsonData->email) ? $jsonData->email : null;

    if (!isset($jsonData->password)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Password required");
        $response->send();
        exit;
    }

    $password = $jsonData->password;

    $session = new Session();

    $session->loginUser($email, $username, $password);


}
else
{
    $response = new Response();
    $response->setHttpStatusCode(405);
    $response->setSuccess(false);
    $response->addMessage("Requested method not allowed");
    $response->send();
    exit;
}


?>