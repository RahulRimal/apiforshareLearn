<?php

class OrderException extends Exception
{
}

class Order
{
    private $db;

    private $id;
    private $bookId;
    private $sellingUserId;
    private $buyingUserId;
    private $pricePerPiece;
    private $bookCount;
    private $wishlisted;
    private $postType;


    public function __construct()
    {
        try {
            $this->db = new Database();
        } catch (PDOException $ex) {
            error_log('fun Post Construct -->: ' . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error !!");
            $response->send();
            exit;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBookId()
    {
        return $this->bookId;
    }

    public function getSellingUserId()
    {
        return $this->sellingUserId;
    }

    public function getBuyingUserId()
    {
        return $this->buyingUserId;
    }

    public function getPricePerPiece()
    {
        return $this->pricePerPiece;
    }

    public function getBookCount()
    {
        return $this->bookCount;
    }

    public function getWishlisted()
    {
        return $this->wishlisted;
    }

    public function getPostType()
    {
        return $this->postType;
    }


    public function setId($id)
    {
        if (is_null($id))
            throw new OrderException('Order ID can\'t be null');
        elseif (empty($id))
            throw new OrderException('Order ID can\'t be empty');
        elseif (!is_numeric($id))
            throw new OrderException('Order ID must be a number');
        else
            $this->id = $id;
    }

    public function setBookId($bookId)
    {
        if (is_null($bookId))
            throw new OrderException('Book ID can\'t be null');
        elseif (empty($bookId))
            throw new OrderException('Book ID can\'t be empty');
        elseif (!is_numeric($bookId))
            throw new OrderException('Book ID must be a number');
        else
            $this->bookId = $bookId;
    }
    
    public function setSellingUserId($userId)
    {
        $userId = intval($userId);
        if (is_null($userId))
            throw new OrderException('Selling User ID can\'t be null');
        elseif (empty($userId))
            throw new OrderException('Selling User ID can\'t be empty');
        elseif (!is_numeric($userId))
            throw new OrderException('Selling User ID must be a number');
        else
            $this->sellingUserId = $userId;
    }

    public function setBuyingUserId($userId)
    {
        $userId = intval($userId);
        if (is_null($userId))
            throw new OrderException('Buying User ID can\'t be null');
        elseif (empty($userId))
            throw new OrderException('Buying User ID can\'t be empty');
        elseif (!is_numeric($userId))
            throw new OrderException('Buying User ID must be a number');
        else
            $this->buyingUserId = $userId;
    }

    public function setPricePerPiece($price)
    {
        $price = intval($price);
        if (is_null($price))
            throw new OrderException('PricePerPiece can\'t be null');
        elseif (empty($price))
            throw new OrderException('PricePerPiece can\'t be empty');
        elseif (!is_numeric($price))
            throw new OrderException('PricePerPiece Price must be a number');
        else
            $this->pricePerPiece = $price;
    }

    public function setPostType($postType)
    {
        if (is_null($postType))
            throw new OrderException('Post type can\'t be null');
        elseif (empty($postType))
            throw new OrderException('Post type can\'t be empty');
        // elseif ($postType != 'S' || $postType != 'B')
        //     throw new OrderException('Post type must be either Selling or Buying');
        else
            $this->postType = $postType;
    }

    public function setBookCount($bookCount)
    {
        if (is_null($bookCount))
            $this->bookCount = null;
        if (empty($bookCount))
            // throw new OrderException('Books Count can\'t be empty');
            $this->bookCount = null;
        elseif (!is_numeric($bookCount))
            throw new OrderException('Books count must be numeric value');
        else
            $this->bookCount = $bookCount;
    }

    public function setOrderWishlist($wishlisted)
    {
        if (is_null($wishlisted))
            $this->wishlisted = null;
        if (empty($wishlisted))
            // throw new OrderException('Book wishlist can\'t be empty');
            $this->wishlisted = null;
        elseif (!is_numeric($wishlisted))
            throw new OrderException('Book wishlist must be numeric value');
        else
            $this->wishlisted = $wishlisted;
    }

    public function setOrderFromRow($row)
    {
        $this->setId($row->id);
        $this->setBookId($row->bookId);
        $this->setSellingUserId($row->sellingUserId);
        $this->setBuyingUserId($row->buyingUserId);
        $this->setPricePerPiece($row->pricePerPiece);
        $this->setBookCount($row->bookCount);
        $this->setPostType($row->postType);
        $this->setOrderWishlist($row->wishlisted);
    }

    public function setOrderFromArray($data)
    {
        isset($data['id']) ?
            $this->setId($data['id']) : false;
        isset($data['bookId']) ? $this->setBookId($data['bookId']) : false;
        isset($data['sellingUserId']) ? $this->setSellingUserId($data['sellingUserId']) : false;
        isset($data['buyingUserId']) ? $this->setBuyingUserId($data['buyingUserId']) : false;
        isset($data['pricePerPiece']) ? $this->setPricePerPiece($data['pricePerPiece']) : false;
        isset($data['bookCount']) ? $this->setBookCount($data['bookCount']) : false;
        isset($data['postType']) ? $this->setPostType($data['postType']) : false;
        isset($data['wishlisted']) ? $this->setOrderWishlist($data['wishlisted']) : false;
        
    }

    public function returnOrderAsArray()
    {
        $post = array();

        $post['id'] = $this->id;
        $post['bookId'] = $this->bookId;
        $post['sellingUserId'] = $this->sellingUserId;
        $post['buyingUserId'] = $this->buyingUserId;
        $post['pricePerPiece'] = $this->pricePerPiece;
        $post['bookCount'] = $this->bookCount;
        $post['postType'] = $this->postType;
        $post['wishlisted'] = $this->wishlisted;

        return $post;
    }

    private function getOrder($id)
    {
        try {
            $this->setId($id);
            $this->db->query('SELECT * FROM orderItem where id = :orderId');
            $this->db->bind(':orderId', $this->id);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0)
                return $row;
            else {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Order not found");
                $response->send();
                exit;
            }
        } catch (OrderException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun->GetOrder.. :" . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Couldn't retrieve data from database");
            $response->send();
            exit;
        }
    }

    public function getUserOrders($uid)
    {

        try {
            $this->setBuyingUserId($uid);
            
            $this->db->query('SELECT * FROM orderItem WHERE buyingUserId = :userId');
            $this->db->bind(":userId", $this->buyingUserId);

            $rows = $this->db->resultset();

            if ($this->db->rowCount() > 0) {

                $orderArray = array();

                foreach ($rows as $row) {
                    $this->setOrderFromRow($row);

                    $orderArray[] = $this->returnOrderAsArray();
                }

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['orders'] = $orderArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Orders retrieved successfully');
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Could\'t retrieve orders, please try again');
                $response->send();
                exit;
            }
        } catch (OrderException $ex) {
            die('here');
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUserOrders: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getOrderById($id)
    {
        $id = intval($id);

        try {
            $this->setId($id);

            $this->db->query('SELECT * FROM orderItem WHERE id = :orderId');
            $this->db->bind(':orderId', $this->id);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {

                $this->setOrderFromRow($row);

                $orderArray[] = $this->returnOrderAsArray();

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['order'] = $orderArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Order retrievd successfully');
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
        } catch (OrderException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getOrderById: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getAnnonimusOrder()
    {
        try {

            $this->db->query('SELECT * FROM orderItem LIMIT 10');

            $rows = $this->db->resultset();

            if ($this->db->rowCount() > 0) {

                $orderArray = array();

                foreach ($rows as $row) {
                    $this->setOrderFromRow($row);

                    $orderArray[] = $this->returnOrderAsArray();
                }

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['orders'] = $orderArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Orders retrievd successfully');
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Couldn\'t retrieve orders, please try again');
                $response->send();
                exit;
            }
        } catch (OrderException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getAnnonimusOrder: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    

    public function orderExists($uid, $bookId = null)//, $bookName = null)
    {
        try {
            $this->setBuyingUserId($uid);
            if (!is_null($bookId)) {

                $this->setBookId($bookId);
                $this->db->query('SELECT COUNT(id) as totalCount FROM orderItem where buyingUserId = :userId AND bookId = :bookId');

                $this->db->bind(':userId', $this->buyingUserId);
                $this->db->bind(':bookId', $this->bookId);
            }
            // elseif (!is_null($bookName)) {
            //     $this->setBookName($bookName);
            //     $this->db->query('SELECT COUNT(id) as totalCount FROM post where userId = :userId AND bookName = :book');

            //     $this->db->bind(':userId', $this->userId);
            //     $this->db->bind(':book', $this->bookName);
            // }
            else {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
            $row = $this->db->single();

            if ($row->totalCount > 0)
                return true;

            return false;
        } catch (OrderException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun OrderExists: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function orderExistsCheck($id)
    {
        try {
            $this->setId($id);
            
            $this->db->query('SELECT COUNT(id) as totalCount FROM orderItem where id = :id');

            $this->db->bind(':id', $this->id);

            // elseif (!is_null($bookName)) {
            //     $this->setBookName($bookName);
            //     $this->db->query('SELECT COUNT(id) as totalCount FROM post where userId = :userId AND bookName = :book');

            //     $this->db->bind(':userId', $this->userId);
            //     $this->db->bind(':book', $this->bookName);
            // }
            
            $row = $this->db->single();

            if ($row->totalCount > 0)
                return true;

            return false;
        } catch (OrderException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun OrderExists: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    // public function createOrder($uid, $data)
    public function createOrder($uid, $data)
    {
        $uid = intval($uid);

        try {
            // $this->setUserId($uid);
            $this->setBuyingUserId($uid);
            // $data['postedOn'] = date("Y-m-d H:i:s");
            $this->setOrderFromArray($data);

            // if ($this->orderExists($this->userId, null, $this->bookName)) {
                if ($this->orderExists($this->buyingUserId, $this->bookId, null)) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Order already Posted");
                $response->send();
                exit;
            }

            $this->db->query('INSERT INTO orderItem (id, bookId, sellingUserId, buyingUserId, pricePerPiece, bookCount, wishlisted, postType, postedOn) VALUES (null, :bookId, :sellingUserId, :buyingUserId, :pricePerPiece, :bookCount, :wishlisted, :postType, null)');

            $this->db->bind(':bookId', $this->bookId);
            $this->db->bind(':sellingUserId', $this->sellingUserId);
            $this->db->bind(':buyingUserId', $this->buyingUserId);
            $this->db->bind(':pricePerPiece', $this->pricePerPiece);
            $this->db->bind(':bookCount', $this->bookCount);
            $this->db->bind(':wishlisted', $this->wishlisted);
            $this->db->bind(':postType', $this->postType);

            if ($this->db->execute()) {
                $postId = $this->db->lastInsertId();
                $this->setId($postId);

                if (is_null($this->id)) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't fetch order data after creating new order");
                    $response->send();
                    exit;
                }

                $this->db->query('SELECT * FROM  orderItem where id = :orderId');
                $this->db->bind(":orderId", $this->id);

                $row = $this->db->single();

                if ($this->db->rowCount() < 1) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't get order information data after creating new order");
                    $response->send();
                    exit;
                }

                $this->setOrderFromRow($row);

                $userArray = array();

                $userArray[] = $this->returnOrderAsArray();

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['order'] = $userArray;

                $response = new Response();
                $response->setHttpStatusCode(201);
                $response->setSuccess(true);
                $response->addMessage("Order Placed Successfully");
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Error placing order, please try again");
                $response->send();
                exit;
            }
        } catch (OrderException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun createOrder: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function updateOrder($id, $data)
    {
        try {
            $data['buyingUserId'] = intval($data['buyingUserId']);
            $this->setBuyingUserId($data['buyingUserId']);
            $this->setId($id);

            $this->setOrderFromArray($data);

            if (!$this->orderExists($this->buyingUserId, $this->bookId)) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find the order to update");
                $response->send();
                exit;
            }
            
            $sellingUserIdUpdated = false;
            $buyingUserIdUpdated = false;
            $pricePerPieceUpdated = false;
            $bookCountUpdated = false;
            $wishlistedUpdated = false;
            $postTypeUpdated = false;

            $queryFields = "";

            $this->db->query('SELECT * FROM orderItem where id = :orderId');
            $this->db->bind(":orderId", $this->id);

            $row = $this->db->single();

            $this->setOrderFromRow($row);

            if (array_key_exists('sellingUserId', $data)) {
                if ((strcmp($data["sellingUserId"], $this->sellingUserId)) != 0) {
                    $sellingUserIdUpdated = true;
                    $this->setSellingUserId($data['sellingUserId']);
                    $queryFields .= "sellingUserId = :sellingUserId, ";
                }
            }

            if (array_key_exists('buyingUserId', $data)) {
                if ((strcmp($data["buyingUserId"], $this->buyingUserId)) != 0) {
                    $buyingUserIdUpdated = true;
                    $this->setBuyingUserId($data['buyingUserId']);
                    $queryFields .= "buyingUserId = :buyingUserId, ";
                }
            }

            if (array_key_exists('pricePerPiece', $data)) {
                if ((strcmp($data["pricePerPiece"], $this->pricePerPiece)) != 0) {
                    $pricePerPieceUpdated = true;
                    $this->setPricePerPiece($data['pricePerPiece']);
                    $queryFields .= "pricePerPiece = :pricePerPiece, ";
                }
            }

            if (array_key_exists('bookCount', $data)) {
                if ((strcmp($data["bookCount"], $this->bookCount)) != 0) {
                    $bookCountUpdated = true;
                    $this->setBookCount($data['bookCount']);
                    $queryFields .= "bookCount = :bookCount, ";
                }
            }

            if (array_key_exists('wishlisted', $data)) {
                if ((strcmp($data["wishlisted"], $this->wishlisted)) != 0) {
                    $wishlistedUpdated = true;
                    $this->setOrderWishlist($data['wishlisted']);
                    $queryFields .= "wishlisted = :wishlisted, ";
                }
            }

            if (array_key_exists('postType', $data)) {
                if ((strcmp($data["postType"], $this->postType)) != 0) {
                    $postTypeUpdated = true;
                    $this->setPostType($data['postType']);
                    $queryFields .= "postType = :postType, ";
                }
            }

            $queryFields = rtrim($queryFields, ", ");

            if (!$buyingUserIdUpdated && !$sellingUserIdUpdated && !$bookCountUpdated && !$pricePerPieceUpdated && !$wishlistedUpdated && !$postTypeUpdated) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("No new information to update");
                $response->send();
                exit;
            }

            $this->db->query("UPDATE orderItem SET " . $queryFields . " WHERE id = :orderId");
            $this->db->bind(':orderId', $this->id);

            if($sellingUserIdUpdated)
                $this->db->bind(":sellingUserId", $this->sellingUserId);
            
            if($buyingUserIdUpdated)
                $this->db->bind(":buyingUserId", $this->buyingUserId);
            
            if($bookCountUpdated)
                $this->db->bind(":bookCount", $this->bookCount);

            if($pricePerPieceUpdated)
                $this->db->bind(":pricePerPiece", $this->pricePerPiece);

            if($wishlistedUpdated)
                $this->db->bind(":wishlisted", $this->wishlisted);

            if($postTypeUpdated)
                $this->db->bind(":postType", $this->postType);

            $this->db->execute();
            // $this->db->execute() or die ("SQL Error: $DBI::errstr\n");

            // die(mysqli_error($this->db->execute()));

            if ($this->db->rowCount() > 0) {

                $row = $this->getOrder($this->id);

                $this->setOrderFromRow($row);

                $orderArray = array();
                $orderArray[] = $this->returnOrderAsArray();

                $returnData = array();

                $returnData["rows_returned"] = $this->db->rowCount();
                $returnData["orders"] = $orderArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Order Information Updated successfully");
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {

                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
        } catch (OrderException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun updateOrder: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function deleteOrder($id, $uid)
    {
        $id = intval($id);
        $uid = intval($uid);
        try {
            $this->setId($id);
            $this->setBuyingUserId($uid);

            // if (!$this->orderExists($this->buyingUserId, null)) {
                if (!$this->orderExistsCheck($this->id)) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find the order to delete");
                $response->send();
                exit;
            }

            // $this->db->query('DELETE FROM orderItem WHERE id = :orderId AND userId = :userId');
            $this->db->query('DELETE FROM orderItem WHERE id = :orderId AND buyingUserId = :userId');
            $this->db->bind(':orderId', $this->id);
            $this->db->bind(':userId', $this->buyingUserId);

            if ($this->db->execute()) {
                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Order Deleted Successfully");
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Couldn't delete the order");
                $response->send();
                exit;
            }
        } catch (OrderException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun deleteOrder: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }
}
