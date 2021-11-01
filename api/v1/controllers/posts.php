<?php

require('../../../core/init.php');
require_once('../libraries/Post.php');
require_once('../libraries/Response.php');
require_once('../libraries/Session.php');


?>

<?php
if (!isset($_SERVER['HTTP_AUTHORIZATION']) || strlen($_SERVER['HTTP_AUTHORIZATION']) < 1) {
    $response = new Response();
    $response->setHttpStatusCode(401);
    $response->setSuccess(false);
    (!isset($_SERVER['HTTP_AUTHORIZATION']) ? $response->addMessage("Access token missing from the header") : false);
    (strlen($_SERVER['HTTP_AUTHORIZATION']) < 1 ? $response->addMessage("Access token cannot be blank") : false);
    $response->send();
    exit;
}

$accessToken = $_SERVER['HTTP_AUTHORIZATION'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['user'])) {

        $uId = $_GET['user'];

        $post = new Post();
        $post->getUserPost($uId);
    }
    //  else {
    //     $response = new Response();
    //     $response->setHttpStatusCode(400);
    //     $response->setSuccess(false);
    //     $response->addMessage("User ID required to get Posts");
    //     $response->send();
    //     exit;
    // }

    elseif (isset($_GET['post'])) {

        $postId = $_GET['post'];

        $post = new Post();
        $post->getPostById($postId);
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Post ID or User ID required to get Posts");
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

    $sess = new Session();

    $sess = $sess->getSessionInfo($accessToken);

    $uId = $sess->getUserId();

    if(!isset($jsonData->bookName) || !isset($jsonData->description) || !isset($jsonData->boughtDate) || !isset($jsonData->price) || !isset($jsonData->postType) || !isset($jsonData->postedOn)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        !isset($jsonData->bookName) ? $response->addMessage("Book name is required to create a post") : false;
        !isset($jsonData->description) ? $response->addMessage("Book description is required to create a post") : false;
        !isset($jsonData->boughtDate) ? $response->addMessage("Book bought date is required to create a post") : false;
        !isset($jsonData->price) ? $response->addMessage("Book price is required to create a post") : false;
        !isset($jsonData->postType) ? $response->addMessage("Post type is required to create a post") : false;
        !isset($jsonData->postedOn) ? $response->addMessage("Post creation date is required to create a post") : false;
        $response->send();
        exit;
    }

    $post = new Post();
    $post->createPost($uId, $jsonData);

} else {
    $response = new Response();
    $response->setHttpStatusCode(405);
    $response->setSuccess(false);
    $response->addMessage("Requested method not allowed");
    $response->send();
    exit;
}



?>