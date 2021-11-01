<?php

class PostException extends Exception
{
}



class Post
{
    private $db;

    private $id;
    private $userId;
    private $bookName;
    private $author;
    private $description;
    private $boughtDate;
    private $price;
    private $postType;
    private $postRating;
    private $postedOn;


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

    public function getUserId()
    {
        return $this->userId;
    }

    public function getBookName()
    {
        return $this->bookName;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getBoughtDate()
    {
        return $this->boughtDate;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getPostType()
    {
        return $this->postType;
    }

    public function getPostRating()
    {
        return $this->postRating;
    }

    public function getPostedTime()
    {
        return $this->postedOn;
    }

    public function setId($id)
    {
        if (is_null($id))
            throw new PostException('Post ID can\'t be null');
        elseif (empty($id))
            throw new PostException('Post ID can\'t be empty');
        elseif (!is_numeric($id))
            throw new PostException('Post ID must be a number');
        else
            $this->id = $id;
    }

    public function setUserId($userId)
    {
        if (is_null($userId))
            throw new PostException('User ID can\'t be null');
        elseif (empty($userId))
            throw new PostException('User ID can\'t be empty');
        elseif (!is_numeric($userId))
            throw new PostException('User ID must be a number');
        else
            $this->userId = $userId;
    }

    public function setBookName($bookName)
    {
        if (is_null($bookName))
            throw new PostException('Book name can\'t be null');
        elseif (empty($bookName))
            throw new PostException('Book name can\'t be empty');
        elseif (strlen($bookName) < 2 || strlen($bookName) > 255)
            throw new PostException('Invalid Character length for book name');
        else
            $this->bookName = $bookName;
    }

    public function setAuthor($author)
    {
        if (is_null($author))
            $this->author = null;
        if (empty($author))
            // throw new PostException('Author can\'t be empty');
            $this->author = null;
        elseif (strlen($author) < 2 || strlen($author) > 255)
            throw new PostException('Invalid Character length for author');
        else
            $this->author = $author;
    }


    public function setDescription($description)
    {
        if (is_null($description))
            throw new PostException('Description can\'t be null');
        elseif (empty($description))
            throw new PostException('Description can\'t be empty');
        else
            $this->description = $description;
    }

    public function setBoughtDate($boughtDate)
    {
        if (is_null($boughtDate))
            throw new PostException('Bought date can\'t be null');
        elseif (empty($boughtDate))
            throw new PostException('Bought date can\'t be empty');
        else
            $this->boughtDate = $boughtDate;
    }

    public function setPrice($price)
    {
        $price = intval($price);
        if (is_null($price))
            throw new PostException('Price can\'t be null');
        elseif (empty($price))
            throw new PostException('Price can\'t be empty');
        elseif (!is_numeric($price))
            throw new PostException('Book Price must be a number');
        else
            $this->price = $price;
    }

    public function setPostType($postType)
    {
        if (is_null($postType))
            throw new PostException('Post type can\'t be null');
        elseif (empty($postType))
            throw new PostException('Post type can\'t be empty');
        // elseif ($postType != 'S' || $postType != 'B')
        //     throw new PostException('Post type must be either Selling or Buying');
        else
            $this->postType = $postType;
    }

    public function setPostRating($rating)
    {
        if (is_null($rating))
            $this->postRating = null;
        if (empty($rating))
            // throw new PostException('Post ratings can\'t be empty');
            $this->postRating = null;
        elseif (!is_numeric($rating))
            throw new PostException('Post rating must be numeric value');
        // elseif (!is_numeric($rating) || !is_float($rating))
        // elseif (!is_float($rating))
        //     throw new PostException('Post rating must be a numeric value');
        else
            $this->postRating = $rating;
    }

    public function setPostedOn($postedOn)
    {
        if (is_null($postedOn))
            throw new PostException('Posted date can\'t be null');
        else
            $this->postedOn = $postedOn;
    }

    public function createPostFromRow($row)
    {
        $this->setId($row->id);
        $this->setUserId($row->userId);
        $this->setBookName($row->bookName);
        $this->setAuthor($row->author);
        $this->setDescription($row->description);
        $this->setBoughtDate($row->boughtDate);
        $this->setPrice($row->price);
        $this->setPostType($row->postType);
        $this->setPostRating($row->postRating);
        $this->setPostedOn($row->postedOn);
    }

    public function createPostFromArray($data)
    {
        $this->setBookName($data->bookName);
        isset($data->author) ? $this->setAuthor($data->author) : $this->setAuthor(null);
        $this->setDescription($data->description);
        $this->setBoughtDate($data->boughtDate);
        $this->setPrice($data->price);
        $this->setPostType($data->postType);
        isset($data->postRating) ? $this->setPostRating($data->postRating) : $this->setPostRating(null);
        $this->setPostedOn($data->postedOn);
    }

    public function returnPostAsArray()
    {
        $post = array();

        $post['id'] = $this->id;
        $post['userId'] = $this->userId;
        $post['bookName'] = $this->bookName;
        $post['author'] = $this->author;
        $post['description'] = $this->description;
        $post['boughtDate'] = $this->boughtDate;
        $post['price'] = $this->price;
        $post['postType'] = $this->postType;
        $post['postRating'] = $this->postRating;
        $post['postedOn'] = $this->postedOn;

        return $post;
    }

    public function getUserPost($uid)
    {
        try {
            $this->setUserId($uid);

            $this->db->query('SELECT * FROM post WHERE userId = :userId');
            $this->db->bind(':userId', $this->userId);

            $rows = $this->db->resultset();

            if ($this->db->rowCount() > 0) {

                $postArray = array();

                foreach ($rows as $row) {
                    $this->createPostFromRow($row);

                    $postArray[] = $this->returnPostAsArray();
                }

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['posts'] = $postArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Posts retrievd successfully');
                $response->setData($returnData);
                $response->send();
                exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Could\'t retrieve posts, please try again');
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getPostById($id)
    {
        $id = intval($id);

        try {
            $this->setId($id);

            $this->db->query('SELECT * FROM post WHERE id = :postId');
            $this->db->bind(':postId', $this->id);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {

                $this->createPostFromRow($row);

                $postArray[] = $this->returnPostAsArray();

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['posts'] = $postArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Posts retrievd successfully');
                $response->setData($returnData);
                $response->send();
                exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function postOfUserExists($uid, $bookName)
    {
        try {
            $this->setUserId($uid);
            $this->setBookName($bookName);

            $this->db->query('SELECT COUNT(id) as totalCount FROM post where userId = :userId AND bookName = :book');

            $this->db->bind(':userId', $this->userId);
            $this->db->bind(':book', $this->bookName);

            $row = $this->db->single();

            if($row->totalCount > 0)
                return true;
            
            return false;

        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    } 
    public function createPost($uid, $data)
    {
        $uid = intval($uid);

        try {
            $this->setUserId($uid);
            $data->postedOn = date("Y-m-d H:i:s");
            $this->createPostFromArray($data);

            if ($this->postOfUserExists($this->userId, $this->bookName)) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Book already Posted");
                $response->send();
                exit;
            }

            $this->db->query('INSERT INTO post (id, userId, bookName, author, description, boughtDate, price, postType, postRating, postedOn) VALUES (null, :userId, :bookName, :author, :description, :boughtDate, :price, :postType, :postRating, null)');

            $this->db->bind(':userId', $this->userId);
            $this->db->bind(':bookName', $this->bookName);
            $this->db->bind(':author', $this->author);
            $this->db->bind(':description', $this->description);
            $this->db->bind(':boughtDate', $this->boughtDate);
            $this->db->bind(':price', $this->price);
            $this->db->bind(':postType', $this->postType);
            $this->db->bind(':postRating', $this->postRating);

            if ($this->db->execute()) {
                $postId = $this->db->lastInsertId();

                if (is_null($postId)) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't get post data after creating new post");
                    $response->send();
                    exit;
                }

                $this->db->query('SELECT * FROM  post where id = :postId');
                $this->db->bind(':postId', $postId);

                $row = $this->db->single();

                if ($this->db->rowCount() < 1) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't get post data after creating new post");
                    $response->send();
                    exit;
                }

                $this->createPostFromRow($row);

                $userArray = array();

                $userArray[] = $this->returnPostAsArray();

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['posts'] = $userArray;

                $response = new Response();
                $response->setHttpStatusCode(201);
                $response->setSuccess(true);
                $response->addMessage("Post Created Successfully");
                $response->setData($returnData);
                $response->send();
                exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Error creating new post, please try again");
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }
}
