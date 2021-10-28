<?php

use function PHPSTORM_META\type;

class UserException extends Exception
{
}


class User
{

    private $db;
    // private $validator = new Validator();


    private $id;
    private $username;
    private $password;
    private $email;
    private $firstName;
    private $lastName;
    private $class;
    private $description;
    private $followers;
    private $userCreatedDate;

    public function __construct($username, $password, $email = null, $firstName, $lastName, $class = null, $description = null, $followers = null)
    {
        try {
            $this->db = new Database();
        } catch (PDOException $ex) {
            // error_log("Connection Error: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database connection error");
            $response->send();
            exit;
        }

        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setclass($class);
        $this->setDescription($description);
        $this->setFollowers($followers);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFristName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getFollowers()
    {
        return $this->followers;
    }

    public function getUserCreatedDate()
    {
        return $this->userCreatedDate;
    }


    public function setId($id)
    {
        // if(($id == null) || !is_numeric($id) || $id < 1 || $id >  9223372036854775807)
        // {

        // }
        if ($id == null)
            throw new UserException('User Id cannot be null');

        if (!is_numeric($id))
            throw new UserException('Invalid User ID');

        elseif ($id < 1)
            throw new UserException('User id can\'t be zero or smaller');

        elseif ($id >  9223372036854775807)
            throw new UserException('User id too long');

        else
            $this->id = $id;
    }

    public function setUsername($username)
    {
        if ($username == null)
            throw new UserException('Username can\'t be null ');

        elseif ($username == '')
            throw new UserException('Invalid Username');

        elseif (strlen($username) < 1)
            throw new UserException('Invalid Username');

        elseif (strlen($username) > 255)
            throw new UserException('Invalid Username');

        else
            $this->username = $username;
    }

    public function setPassword($password)
    {
        if ($password == null)
            throw new UserException('Password can\'t be null');
        elseif (strlen($password) < 8)
            throw new UserException('Password must be at least 8 characters long');
        elseif (strlen($password) > 255)
            throw new UserException('Password cannot be more than 255 characters long');
        else
            $this->password = $password;
    }

    public function setEmail($email)
    {
        if (!is_null($email)) {
            if (strlen($email) > 255)
                throw new UserException('Email too long');
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
                throw new UserException('Invalid Email');
            // elseif (!$this->validator->isValidEmail($email))
            //     throw new UserException('Invalid Email');
        } else
            $this->email = $email;
    }

    public function setFirstName($firstname)
    {
        if ($firstname == '')
            throw new UserException('Invalid First name');
        elseif (strlen($firstname) < 2)
            throw new UserException('First Name too short');
        elseif (strlen($firstname) > 255)
            throw new UserException('First name too long');
        else
            $this->firstName = $firstname;
    }

    public function setLastName($lastname)
    {
        if ($lastname == '')
            throw new UserException('Invalid First name');
        elseif (strlen($lastname) < 2)
            throw new UserException('First Name too short');
        elseif (strlen($lastname) > 255)
            throw new UserException('First name too long');
        else
            $this->lastName = $lastname;
    }

    public function setclass($class)
    {
        if (!is_null($class)) {
            if (strlen($class) < 1)
                throw new UserException('Invalid Class level');
            elseif ($class == '')
                throw new UserException('Invalid Class level');
        } else
            $this->class = $class;
    }

    public function setDescription($description)
    {
        if ($description == '')
            // throw new UserException('Invalid Description');
            $this->description = null;
        elseif (strlen($description) < 50)
            throw new UserException('Description must be at least 50 characters long');
        else
            $this->description = $description;
    }

    public function setFollowers($followers)
    {
        if ($followers == '')
            // throw new UserException('Invalid Followers List');
            $this->followers = null;
        else
            $this->followers = $followers;
    }

    public function setUserCreatedDate($createdDate)
    {
        $this->userCreatedDate = $createdDate;
    }

    public function returnUserAsArray()
    {
        $user = array();
        $user['id'] = $this->id;
        $user['name'] = $this->firstName . ' ' . $this->lastName;
        $user['username'] = $this->username;
        $user['email'] = $this->email;
        $user['description'] = $this->description;
        $user['class'] = $this->class;
        $user['followers'] = $this->followers;
        $user['createdDate'] = $this->userCreatedDate;

        return $user;
    }

    public function createUserFromRow($row)
    {
        // $this->setId($row['id']);
        // $this->setUsername($row['username']);
        // $this->setEmail($row['email']);
        // $this->setFirstName($row['firstName']);
        // $this->setLastName($row['lastName']);
        // $this->setDescription($row['description']);
        // $this->setClass($row['class']);
        // $this->setFollowers($row['followers']);
        // $this->setUserCreatedDate($row['userCreatedDate']);

        $this->setId($row->id);
        $this->setUsername($row->username);
        $this->setEmail($row->email);
        $this->setFirstName($row->firstName);
        $this->setLastName($row->lastName);
        $this->setDescription($row->description);
        $this->setClass($row->class);
        $this->setFollowers($row->followers);
        $this->setUserCreatedDate($row->userCreatedDate);
    }

    // public function sendUserInAResponse($receivedUser)
    // {

    //     $user = array();

    //     $user['id'] = $receivedUser['id'];
    //     $user['username'] = $receivedUser['username'];
    //     $user['name'] = $receivedUser['id']; 

    //     $response = new Response();
    //     $response->setHttpStatusCode(200);
    //         $response->setSuccess(true);
    //         $response->addMessage("");
    //         $response->send();
    //         exit;
    // }


    public function getDetails($uid)
    {
        $uid = intval($uid);

        $this->setId($uid);
        try {
            $this->db->query('SELECT * FROM user where id = :userId');
            $this->db->bind(':userId', $this->getId());

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {
                $this->createUserFromRow($row);

                $userArray = array();
                $userArray[] = $this->returnUserAsArray();

                $returnData = array();

                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['user'] = $userArray;


                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->toCache(true);
                $response->addMessage("User Information Received successfully");
                $response->setData($returnData);
                // $response->setData($row);
                $response->send();
                exit;
                // $this->setId($row['id']);
                // $this->setUsername($row['username']);
                // $this->setEmail($row['email']);
                // $this->setFirstName($row['firstName']);
                // $this->setLastName($row['lastName']);
                // $this->setDescription($row['description']);
                // $this->setClass($row['class']);
                // $this->setFollowers($row['followers']);
                // $this->setUserCreatedDate($row['userCreatedDate']);
            } else {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("User not found");
                $response->send();
                exit;
            }
        } catch (PDOException $ex) {
            error_log("Fun->GetUserDet.. :" . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Couldn't retrieve data from database");
            $response->send();
            exit;
        }
    }


    public function userExists()
    {
        try {
            $this->db->query('SELECT * FROM user where username = :username');
            $this->db->bind(':username', $this->username);

            // $this->db->execute();

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {
                $response = new Response();
                $response->setHttpStatusCode(409);
                $response->setSuccess(false);
                $response->addMessage("User already exists");
                $response->send();
                exit;
            }
        } catch (PDOException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("UserExist--> : Check in the code");
            $response->send();
            exit;
        }

        return false;
    }

    public function createNewUser()
    {
        if (!$this->userExists()) {
            try {

                $this->db->query('INSERT INTO user(id, username, password, email, firstName, lastName, picture, class, description, followers, userCreatedDate) values (null, :username, :password, :email, :firstName, :lastName, null, :class, :description, :followers, null)');

                $this->db->bind(':username', $this->username);
                $this->db->bind(':password', $this->password);
                $this->db->bind(':email', $this->email);
                $this->db->bind(':firstName', $this->firstName);
                $this->db->bind(':lastName', $this->lastName);
                $this->db->bind(':class', $this->class);
                $this->db->bind(':description', $this->description);
                $this->db->bind(':followers', $this->followers);

                if ($this->db->execute()) {
                    $uId = $this->db->lastInsertId();

                    if (is_null($uId)) {
                        $response = new Response();
                        $response->setHttpStatusCode(500);
                        $response->setSuccess(false);
                        $response->addMessage("Couldn't get user data after Creating new User");
                        $response->send();
                        exit;
                    }

                    $this->db->query('SELECT * FROM  user where id = :userId');
                    $this->db->bind(':userId', $uId);

                    $row = $this->db->single();

                    if ($this->db->rowCount() < 1) {
                        $response = new Response();
                        $response->setHttpStatusCode(500);
                        $response->setSuccess(false);
                        $response->addMessage("Couldn't get user data after Creating new User");
                        $response->send();
                        exit;
                    }

                    $this->createUserFromRow($row);

                    $userArray = array();

                    $userArray[] = $this->returnUserAsArray();

                    $returnData = array();
                    $returnData['rows_returned'] = $this->db->rowCount();
                    $returnData['users'] = $userArray;

                    $response = new Response();
                    $response->setHttpStatusCode(201);
                    $response->setSuccess(true);
                    $response->addMessage("User Created Successfully");
                    $response->setData($returnData);
                    $response->send();
                    exit;
                } else {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Error creating new user, please try again");
                    $response->send();
                    exit;
                }
            } catch (PDOException $ex) {
                error_log("Fun->CreateNewUser :" . $ex, 0);
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Error creating new user");
                $response->send();
                exit;
            }
        }
    }
}
