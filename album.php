<?php
include("includes/header.php");

if (!isset($_SESSION['logged'])) {
    header("Location: register.php");
}

isset($_GET['id']) ? $album_id = htmlspecialchars($_GET['id']) : header("Location: index.php");

$album_id = $conn->real_escape_string($album_id);
$album = $conn->query("SELECT * FROM albums WHERE id = '$album_id'") or die($conn->error);
$artist = $album->fetch_array();

$album = new Album($conn, $artist['id']);
$artist = $album->getArtist();

?>

<div class="entityInfo">

    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>" alt="album cover">
    </div>

    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p><?php echo $artist->getName(); ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> Songs</p>
    </div>

</div>

<div class="tracklistContainer">
    <ul class="tracklist">

        <?php
        $songs = $album->getSongsIds();
        $i = 1;
        foreach ($songs as $song_id) {
            $song = new Song($song_id, $conn);
            $artist = $song->getArtist();

            ?>
            <li class='tracklistRow'>
                <div class='trackCount'>
                    <img class='playButton' src='assets/images/icons/play-white.png' alt='play'>
                    <span class='trackNumber'><?= $i ?></span>
                </div>
                <div class='trackInfo'>
                    <span class="trackName"><?= $song->getTitle(); ?></span>
                    <span class="artistName"><?= $artist->getName(); ?></span>
                </div>

                <div class="trackOptions">
                    <span class="optionsButton"><img src="assets/images/icons/more.png" alt="more"></span>
                </div>

                <div class="trackDuration">
                    <span class="duration"><?= $song->getDuration(); ?></span>
                </div>
            </li>
            <?php
            $i++;
        }
        ?>

    </ul>
</div>

<?php


include("includes/footer.php");
