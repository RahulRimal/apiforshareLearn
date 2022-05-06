<?php
require('../../../core/init.php');
require_once('../libraries/Order.php');
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

    // $response = new Response();

    if (isset($_GET['order'])) {

        $id = $_GET['order'];

        $order = new Order();
        $response = $order->getOrderById($id);
        $response->send();
        exit;
    }

    elseif (isset($_GET['user'])) {

        $userId = $_GET['user'];

        $order = new Order();
        $response = $order->getUserOrders($userId);
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
        else
        {
            $order = new Order();
            $response = $order->getAnnonimusOrder();
            $response->send();
            exit;
        }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    sleep(1);

    if (isset($_SERVER['CONTENT_TYPE']) &&
    (
        ($_SERVER['CONTENT_TYPE'] != 'application/json')
    &&
    ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
    // ||
    // ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
    )) {
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

    if (!isset($jsonData->bookId) || !isset($jsonData->sellingUserId) || !isset($jsonData->buyingUserId) || !isset($jsonData->pricePerPiece) || !isset($jsonData->bookCount) || !isset($jsonData->postType) || !isset($jsonData->wishlisted)) {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        !isset($jsonData->bookId) ? $response->addMessage("Book ID is required to place an order") : false;
        !isset($jsonData->sellingUserId) ? $response->addMessage("Selling User ID is required to place an order") : false;
        !isset($jsonData->buyingUserId) ? $response->addMessage("Buying User ID is required to place an order") : false;
        !isset($jsonData->bookCount) ? $response->addMessage("Book Count is required to place an order") : false;
        !isset($jsonData->pricePerPiece) ? $response->addMessage("Price per piece is required to place an order") : false;
        !isset($jsonData->postType) ? $response->addMessage("Post type is required to place an order") : false;
        !isset($jsonData->wishlisted) ? $response->addMessage("Post wishlisted is required to place an order") : false;
        $response->send();
        exit;
    }

    $data = array();

    if (isset($jsonData->bookId))
        $data['bookId'] = $jsonData->bookId;

    if (isset($jsonData->sellingUserId))
        $data['sellingUserId'] = $jsonData->sellingUserId;

    if (isset($jsonData->buyingUserId))
        $data['buyingUserId'] = $jsonData->buyingUserId;

    if (isset($jsonData->boughtDate))
        $data['boughtDate'] = $jsonData->boughtDate;
    
    if (isset($jsonData->bookCount))
        $data['bookCount'] = $jsonData->bookCount;

    if (isset($jsonData->pricePerPiece))
        $data['pricePerPiece'] = $jsonData->pricePerPiece;

    if (isset($jsonData->postType))
        $data['postType'] = $jsonData->postType;

    // if (isset($jsonData->postRating))
    //     $data['postRating'] = $jsonData->postRating;

    if (isset($jsonData->wishlisted))
        $data['wishlisted'] = $jsonData->wishlisted;
    else
        $data['wishlisted'] = 2;


    $order = new Order();
    $response = $order->createOrder($uId, $data);
    $response->send();
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    sleep(1);

    if (isset($_SERVER['CONTENT_TYPE']) &&
    (
        ($_SERVER['CONTENT_TYPE'] != 'application/json')
    &&
    ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
    // ||
    // ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8')
    )) {
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

    if (isset($_GET['order'])) {

        $id = $_GET['order'];

        $data = array();
        $data['userId'] = $uId;

        if (!isset($jsonData->buyingUserId) || !isset($jsonData->bookId))
        {
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        !isset($jsonData->buyingUserId) ? $response->addMessage("Buying User ID is required to update an order") : false;
        !isset($jsonData->bookId) ? $response->addMessage("Book ID is required to update an order") : false;
        // $response->addMessage("Buying User ID is required to update an order");
        $response->send();
        exit;
        }


        if(isset($jsonData->bookId) || isset($jsonData->sellingBookId) || isset($jsonData->buyingBookId) || isset($jsonData->bookCount) || isset($jsonData->pricePerPiece) || isset($jsonData->postType) || isset($jsonData->wishlisted)) {
            isset($jsonData->bookId) ? $data['bookId'] = $jsonData->bookId : false;
            isset($jsonData->sellingUserId) ? $data['sellingUserId'] = $jsonData->sellingUserId : false;
            isset($jsonData->buyingUserId) ? $data['buyingUserId'] = $jsonData->buyingUserId : false;
            isset($jsonData->bookCount) ? $data['bookCount'] = $jsonData->bookCount : false;
            isset($jsonData->pricePerPiece) ? $data['pricePerPiece'] = $jsonData->pricePerPiece : false;
            isset($jsonData->postType) ? $data['postType'] = $jsonData->postType : false;
            isset($jsonData->wishlisted) ? $data['wishlisted'] = $jsonData->wishlisted : false;

            $order = new Order();
            $response = $order->updateOrder($id, $data);
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

    if (isset($_GET['order'])) {

        $id = $_GET['order'];

        $order = new Order();
        $response = $order->deleteOrder($id, $uId);

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