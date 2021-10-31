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
elseif($_SERVER['REQUEST_METHOD'] == 'PATCH')
{
    if(!isset($_GET['session']))
    {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Session ID required to update session");
        $response->send();
        exit;
    }
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

    if(!isset($jsonData->refreshToken) || strlen($jsonData->refreshToken) < 1)  {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        (!isset($jsonData->refresh_token) ? $response->addMessage("Refresh Token not supplied") : false);
        (strlen($jsonData->refresh_token) < 1 ? $response->addMessage("Refresh Token cannot be blank") : false);
        $response->send();
        exit;
      }

    $session = new Session();
    $session->updateSession($jsonData->refreshToken);


}
elseif($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
    if(!isset($_GET['session']))
    {
        $response = new Response();
    $response->setHttpStatusCode(400);
    $response->setSuccess(false);
    $response->addMessage("Session ID required to delete a session");
    $response->send();
    exit;
    }

    $sessId = $_GET['session'];

    $session = new Session();
    $session->deleteSession($sessId);

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