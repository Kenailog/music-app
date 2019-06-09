<?php

class Artist
{
    private $id;
    private $conn;

    public function __construct($conn, $id)
    {
        $this->id = $id;
        $this->conn = $conn;
    }

    public function getName()
    {
        $query = $this->conn->query("SELECT `name` FROM `artists` WHERE id = '$this->id'") or die($this->conn->error);
        $row = $query->fetch_array();
        return $row['name'];
    }

    public function getSongsIds()
    {
        $query = $this->conn->query("SELECT id FROM songs WHERE artist = '$this->id' ORDER BY plays ASC") or die($this->conn->error);
        while($row = $query->fetch_assoc()) {
            $songs[] = $row['id']; 
        }
        return $songs;
    }
}
