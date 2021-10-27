<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getSellingPostsCount($uid)
    {
        $this->db->query("SELECT * FROM post WHERE userId = :userId
                          AND postType = :postTypeTag    
                        ");

        $this->db->bind(':userId', $uid);
        $this->db->bind(':postTypeTag', 0);

        $rows = $this->db->resultset();

        return $this->db->rowCount();
    }

    public function getBuyingPostsCount($uid)
    {
        $this->db->query("SELECT * FROM post WHERE userId = :userId
                          AND postType = :postTypeTag    
                        ");

        $this->db->bind(':userId', $uid);
        $this->db->bind(':postTypeTag', 1);

        $rows = $this->db->resultset();

        return $this->db->rowCount();
    }


    public function getUserAllPosts($uid)
    {
        $this->db->query("SELECT * FROM post WHERE userId = :userId ");
        $this->db->bind(':userId', $uid);

        $rows = $this->db->resultset();

        return $rows;
    }

    public function getAllPosts()
    {
        $this->db->query("SELECT * FROM post");

        $rows = $this->db->resultset();

        return $rows;
    }


    public function getFilteredPosts()
    {
        $this->db->query("SELECT * FROM post");

        $rows = $this->db->resultset();

        return $rows;
    }

    public function getPost($pid)
    {
        $this->db->query("SELECT * FROM post WHERE id = :postId ");
        $this->db->bind(':postId', $pid);

        $row = $this->db->single();

        return $row;
    }





    public function userIdFromPost($pid)
    {
        $this->db->query("SELECT userId FROM post WHERE id = :postId");

        $this->db->bind(':postId', $pid);

        $row = $this->db->single();

        return $row->userId;
    }



    public function reply($data)
    {
        $this->db->query("INSERT INTO replies(postId, userId, body)
                         VALUES(:postId, :userId, :body)
                        ");
            
        $this->db->bind(':postId', $data['postId']);
        $this->db->bind(':userId', $data['userId']);
        $this->db->bind(':body', $data['body']);

        if($this->db->execute())
            return true;
        else
            return false;

    }


    public function getReplies($postId)
    {
        $this->db->query('SELECT * FROM replies WHERE postId = :postId');
        $this->db->bind(':postId', $postId);

        $rows = $this->db->resultset();

        return $rows;

    }



}
?>