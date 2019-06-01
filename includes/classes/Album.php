<?php

class Album
{
    private $id;
    private $title;
    private $artist_id;
    private $genre;
    private $artworkPath;
    private $conn;

    public function __construct($conn, $id)
    {
        $this->id = $id;
        $this->conn = $conn;

        $query = $this->conn->query("SELECT * FROM albums WHERE id = '$this->id'") or die($this->conn->error);
        $row = $query->fetch_array();

        $this->title = $row['title'];
        $this->artist_id = $row['artist'];
        $this->genre = $row['genre'];
        $this->artworkPath = $row['artworkPath'];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getArtist()
    {
        return new Artist($this->conn, $this->artist_id);
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getArtworkPath()
    {
        return $this->artworkPath;
    }

    public function getNumberOfSongs()
    {
        $query = $this->conn->query("SELECT COUNT(*) FROM songs WHERE album = $this->id") or die($this->conn->error);
        $result = $query->fetch_assoc();
        return $result['COUNT(*)'];
    }
}
