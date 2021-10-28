<?php

require('../../../core/init.php');
require_once('../libraries/User.php');
require_once('../libraries/Response.php');

?>

<?php

// Getting Existing User
// /users/1

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['user'])) {
        $uId = $_GET['user'];

        $user = new User('tempUser', 'tempPass', null, 'tempFirst', 'tempLast', null, null, null);

        $user->getDetails($uId);
    }
    else
    {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("User id not set");
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    if (!isset($jsonData->username) || !isset($jsonData->password) || !isset($jsonData->firstName) || !isset($jsonData->lastName)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        !isset($jsonData->username) ? $response->addMessage("Username is required") : false;
        !isset($jsonData->password) ? $response->addMessage("Password is required") : false;
        !isset($jsonData->firstName) ? $response->addMessage("First name is required") : false;
        !isset($jsonData->lastName) ? $response->addMessage("Last name is required") : false;
        $response->send();
        exit;
    }

    try {
        $newUser = new User($jsonData->username, $jsonData->password, isset($jsonData->email) ? $jsonData->email : null, $jsonData->firstName, $jsonData->lastName, isset($jsonData->class) ? $jsonData->class : null, isset($jsonData->description) ? $jsonData->description : null, isset($jsonData->followers) ? $jsonData->followers : null);

        $newUser->createNewUser();

    } catch (UserException $ex) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage($ex->getMessage());
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD' == 'PATCH']) {
} elseif ($_SERVER['REQUEST_METHOD' == 'DELETE']) {
    if(isset($_GET['user']))
    {

    }
} else {
    $response = new Response();
    $response->setHttpStatusCode(405);
    $response->setSuccess(false);
    $response->addMessage("Requested method not allowed");
    $response->send();
    exit;
}






?>