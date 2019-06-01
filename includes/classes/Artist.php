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
}
