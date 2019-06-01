<?php

class Artist
{
    private $id;
    private $conn;

    public function __constructor($id, $conn)
    {
        $this->id = $id;
        $this->conn = $conn;
    }

    public function getName()
    {
        $query = $this->conn->query("SELECT name FROM artists WHERE id = '$this->name'");
        $row = $query->fetch_array();
        return $row['name'];
    }
}
