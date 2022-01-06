<?php

class Chat
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getAllMessages($sender, $receiver)
    {

        // $this->db->query("SELECT * FROM chat WHERE outgoing_id = :sender AND incoming_id = :receiver OR outgoing_id = :receiver AND incoming_id = :sender ORDER BY id ASC");
        // $this->db->query("SELECT * FROM chat
        // INNER JOIN user.picture ON chat.outgoing_id = user.id
        // WHERE (outgoing_id = :sender AND incomingid = :receiver)
        // OR (outgoing_id = :receiver AND incoming_id = :sender)
        // ORDER BY chat.id");

        // $this->db->query("SELECT chat.*, user.picture FROM chat
        // INNER JOIN user ON chat.outgoing_id = user.id
        // WHERE (outgoing_id = :sender AND incomingid = :receiver)
        // OR (outgoing_id = :receiver AND incoming_id = :sender)
        // ORDER BY chat.id");

        $this->db->query("SELECT chat.*, user.* FROM chat
        INNER JOIN user ON chat.outgoing_id = user.id
        WHERE (outgoing_id = :sender AND incoming_id = :receiver)
        OR (outgoing_id = :receiver AND incoming_id = :sender)
        ORDER BY chat.id");

        $this->db->bind(':sender', $sender);
        $this->db->bind(':receiver', $receiver);

        $rows = $this->db->resultset();
        return $rows;
    }

    public function getMessage($sender, $receiver)
    {
    
            // $this->db->query("SELECT * FROM chat WHERE outgoing_id = :sender AND incoming_id = :receiver OR outgoing_id = :receiver AND incoming_id = :sender ORDER BY id DESC");
            $this->db->query("SELECT chat.*, user.* FROM chat
        INNER JOIN user ON chat.outgoing_id = user.id
        WHERE (outgoing_id = :sender AND incoming_id = :receiver)
        OR (outgoing_id = :receiver AND incoming_id = :sender)
        ORDER BY chat.id LIMIT 1");
            $this->db->bind(':sender', $sender);
            $this->db->bind(':receiver', $receiver);
    
            $row = $this->db->single();
    
            return $row;
    }


    public function sendMessage($sender, $receiver, $message)
    {
        $this->db->query("INSERT INTO chat (outgoing_id, incoming_id, message) VALUES (:sender, :receiver, :message)");
        $this->db->bind(':sender', $sender);
        $this->db->bind(':receiver', $receiver);
        $this->db->bind(':message', $message);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }












}

?>