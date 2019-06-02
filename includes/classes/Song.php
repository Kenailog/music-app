<?php

class Song
{
    private $title;
    private $album_id;
    private $artist_id;
    private $genre;
    private $path;
    private $duration;

    public function __construct($id, $conn)
    {
        $this->conn = $conn;
        $this->id = $id;

        $query = $this->conn->query("SELECT * FROM songs WHERE id = $this->id") or die($this->conn->error);
        $song = $query->fetch_assoc();
        $this->title = $song['title'];
        $this->album_id = $song['album'];
        $this->artist_id = $song['artist'];
        $this->genre = $song['title'];
        $this->path = $song['path'];
        $this->duration = $song['duration'];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAlbum()
    {
        return new Album($this->conn, $this->album_id);
    }

    public function getArtist()
    {
        return new Artist($this->conn, $this->artist_id);
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getPath()
    {
        return $this->path;
    }
}
