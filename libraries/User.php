<?php

use function PHPSTORM_META\type;

class User
{
    private $db;


    public function __construct()
    {

        $this->db = new Database;
    }



    public function login($userEmail, $password)
    {
        $this->db->query("SELECT * From user
        WHERE email = :email AND password = :password
        ");
        $this->db->bind(":email", $userEmail);
        $this->db->bind(":password", $password);

        $row = $this->db->single();

        if($this->db->rowCount() > 0)
        {
            $this->setUserData($row);
            return true;
        }
        else
        return false;

    }


    private function setUserData($row){
		$_SESSION['is_logged_in'] = true;
		$_SESSION['user_id'] = $row->id;
		$_SESSION['username'] = $row->userName;
		$_SESSION['name'] = $row->firstName;
	}


    public function logout(){
		unset($_SESSION['is_logged_in']);
		unset($_SESSION['user_id']);
		unset($_SESSION['username']);
		unset($_SESSION['name']);
		return true;
	}


    public function getUserInfo($uid)
    {
        $this->db->query("SELECT * FROM user WHERE id = :userId");

        $this->db->bind(':userId', $uid);

        $row = $this->db->single();

        // if($this->db->rowCount() > 0)
        return $row;
    }


    public function userOverallRating($uid)
    {
        $totalRating = 0;
        $this->db->query("SELECT postRating FROM post WHERE userId = :userId");

        $this->db->bind(':userId', $uid);

        $ratings = $this->db->resultset();

        foreach($ratings as $rating)
        {
            $totalRating += $rating->postRating;
        }

        return $totalRating;
    }

    public function userFollowersCount($uid)
    {
        $this->db->query("SELECT followers FROM user WHERE id = :userId");

        $this->db->bind(':userId', $uid);
        
        $row = $this->db->single();

        $followers = $row->followers;

        $followers = explode(',', $followers);

        $followersCount = count($followers);

        return $followersCount;

    }

}
?>