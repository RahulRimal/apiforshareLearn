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
    isset($_SERVER['HTTP_AUTHORIZATION']) ? ((strlen($_SERVER['HTTP_AUTHORIZATION']) < 1 ? $response->addMessage("Access token cannot be blank") : false)) : false;
    $response->send();
    exit;
}

// if (isset($_SERVER['HTTP_AUTHORIZATION']) || strlen($_SERVER['HTTP_AUTHORIZATION']) < 1) {
//     $response = new Response();
//     $response->setHttpStatusCode(401);
//     $response->setSuccess(false);
//     (!isset($_SERVER['HTTP_AUTHORIZATION']) ? $response->addMessage("Access token missing from the header") : false);
//     isset($_SERVER['HTTP_AUTHORIZATION']) ?((strlen($_SERVER['HTTP_AUTHORIZATION']) < 1 ? $response->addMessage("Access token cannot be blank") : false)): false;
//     $response->send();
//     exit;
// }

$accessToken = $_SERVER['HTTP_AUTHORIZATION'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['user'])) {

        $uId = $_GET['user'];

        $post = new Post();
        $response = $post->getUserPost($uId);
        $response->send();
        exit;
    } elseif (isset($_GET['post'])) {

        $postId = $_GET['post'];

        $post = new Post();
        // $post->createPostFolder($postId);
        $response = $post->getPostById($postId);
        $response->send();
        exit;
    }
    // else {
    //     $response = new Response();
    //     $response->setHttpStatusCode(400);
    //     $response->setSuccess(false);
    //     $response->addMessage("Post ID or User ID required to get Posts");
    //     $response->send();
    //     exit;
    // }
    else {
        $post = new Post();
        $response = $post->getAnnonimusPost();
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    sleep(1);

    if (isset($_GET['postPictures'])) {
        $pId = $_GET['postPictures'];

        $post = new Post();

        $picCount = 1;

        $receivedData = array();

        foreach ($_FILES as $file) {

            $receivedData['pic' . strval($picCount)] = $file;
            $picCount++;
        }

        $pictureArray = array();

        $pictureArray['pictures'] = $receivedData;


        if (isset($_FILES)) {
            $response = $post->updatePostImages($pId, $pictureArray);
            $response->send();
            exit;
        }


        // if(isset($_FILES['picture']))
        // {
        //     $receivedData['picture'] = $_FILES['picture'];

        //     $response = $user->updateInfo($uId, $receivedData);
        // $response->send();
        // exit;
        // }


    }

    if (isset($_GET['deletePostPictures'])) {

        $pId = $_GET['deletePostPictures'];

        $post = new Post();

        $rawData = file_get_contents('php://input');

        if (!$jsonData = json_decode($rawData)) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage("Invalid JSON body");
            $response->send();
            exit;
        }

        $response = $post->deletePostImages($pId, $jsonData->pics);
        $response->send();
        exit;

        // if(isset($_FILES))
        // {
        //     $response = $post->deletePostImages($pId, $jsonData->pics);
        //     $response->send();
        //     exit;
        // }


        // if(isset($_FILES['picture']))
        // {
        //     $receivedData['picture'] = $_FILES['picture'];

        //     $response = $user->updateInfo($uId, $receivedData);
        // $response->send();
        // exit;
        // }


    }



    if (
        isset($_SERVER['CONTENT_TYPE']) &&
        (
            ($_SERVER['CONTENT_TYPE'] != 'application/json')
            &&
            ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
            // ||
            // ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
        )
    ) {
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

    if (!isset($jsonData->bookName) || !isset($jsonData->description) || !isset($jsonData->boughtDate) || !isset($jsonData->bookCount) || !isset($jsonData->price) || !isset($jsonData->postType) || !isset($jsonData->postedOn)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        !isset($jsonData->bookName) ? $response->addMessage("Book name is required to create a post") : false;
        !isset($jsonData->description) ? $response->addMessage("Book description is required to create a post") : false;
        !isset($jsonData->boughtDate) ? $response->addMessage("Book bought date is required to create a post") : false;
        !isset($jsonData->bookCount) ? $response->addMessage("Book Count is required to create a post") : false;
        !isset($jsonData->price) ? $response->addMessage("Book price is required to create a post") : false;
        !isset($jsonData->postType) ? $response->addMessage("Post type is required to create a post") : false;
        !isset($jsonData->postedOn) ? $response->addMessage("Post creation date is required to create a post") : false;
        $response->send();
        exit;
    }

    $data = array();

    if (isset($jsonData->bookName))
        $data['bookName'] = $jsonData->bookName;

    if (isset($jsonData->author))
        $data['author'] = $jsonData->author;

    if (isset($jsonData->description))
        $data['description'] = $jsonData->description;

    if (isset($jsonData->boughtDate))
        $data['boughtDate'] = $jsonData->boughtDate;

    if (isset($jsonData->bookCount))
        $data['bookCount'] = $jsonData->bookCount;

    if (isset($jsonData->price))
        $data['price'] = $jsonData->price;

    if (isset($jsonData->postType))
        $data['postType'] = $jsonData->postType;

    if (isset($jsonData->postRating))
        $data['postRating'] = $jsonData->postRating;

    if (isset($jsonData->wishlisted))
        $data['wishlisted'] = $jsonData->wishlisted;
    else
        $data['wishlisted'] = 2;


    $post = new Post();
    $response = $post->createPost($uId, $data);
    $response->send();
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    sleep(1);

    if (
        isset($_SERVER['CONTENT_TYPE']) &&
        (
            ($_SERVER['CONTENT_TYPE'] != 'application/json')
            &&
            ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
            // ||
            // ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
        )
    ) {
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

    if (isset($_GET['post'])) {

        $id = $_GET['post'];

        $data = array();
        $data['userId'] = $uId;

        if (isset($jsonData->bookName) || isset($jsonData->author) || isset($jsonData->description) || isset($jsonData->boughtDate) || isset($jsonData->price) || isset($jsonData->postType) || isset($jsonData->postRating)) {
            isset($jsonData->bookName) ? $data['bookName'] = $jsonData->bookName : false;
            isset($jsonData->author) ? $data['author'] = $jsonData->author : false;
            isset($jsonData->description) ? $data['description'] = $jsonData->description : false;
            isset($jsonData->boughtDate) ? $data['boughtDate'] = $jsonData->boughtDate : false;
            isset($jsonData->price) ? $data['price'] = $jsonData->price : false;
            isset($jsonData->postType) ? $data['postType'] = $jsonData->postType : false;
            isset($jsonData->postRating) ? $data['postRating'] = $jsonData->postRating : false;

            $post = new Post();
            $response = $post->updatePost($id, $data);
            $response->send();
            exit;
        } else {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage("Nothing changed to update");
            $response->send();
            exit;
        }
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Post ID required to update the post");
        $response->send();
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $sess = new Session();

    $sess = $sess->getSessionInfo($accessToken);

    $uId = $sess->getUserId();

    if (isset($_GET['post'])) {

        $id = $_GET['post'];

        $post = new Post();
        $response = $post->deletePost($id, $uId);

        $response->send();
        exit;
    } else {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Post ID required to delete the post");
        $response->send();
        exit;
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