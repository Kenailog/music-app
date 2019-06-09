<?php
include_once("includes/includedFiles.php");

if (!isset($_SESSION['logged'])) {
    header("Location: register.php");
}

isset($_GET['id']) ? $artist_id = htmlspecialchars($_GET['id']) : header("Location: index.php");

$artist = new Artist($conn, $artist_id);

?>

<div class="entityInfo borderBottom">
    <div class="centerSection">
        <div class="artistInfo">
            <h1 class='artistName'> <?php echo $artist->getName(); ?></h1>
        </div>
        <div class="headerButtons">
            <button class="button green" onclick="playFirstSong()">Play</button>
        </div>
    </div>
</div>

<div class="tracklistContainer borderBottom">
    <h2>Songs</h2>
    <ul class="tracklist">

        <?php
        $songs = $artist->getSongsIds();
        $i = 1;
        foreach ($songs as $song_id) {

            if ($i > 5) {
                break;
            }

            $song = new Song($song_id, $conn);
            $artist = $song->getArtist();

            ?>
            <li class='tracklistRow'>
                <div class='trackCount'>
                    <img class='playButton' src='assets/images/icons/play-white.png' alt='play' onclick="setTrack(<?= strval($song_id) ?>, tempPlaylist, true)">
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

        <script>
            var songIds = '<?= json_encode($songs) ?>';
            tempPlaylist = JSON.parse(songIds);
        </script>

    </ul>
</div>

<div class="gridViewContainer">
    <h2>Albums</h2>
    <?php
    $albums = $conn->query("SELECT * FROM albums WHERE artist = '$artist_id'") or die($conn->error);
    while ($row = $albums->fetch_array()) {
        echo "<div class='gridViewItem'>
                <span role='link' tabindex='0' onclick='loadContent(\"album.php?id=" . $row['id'] . "\")'>
                    <img src=" . $row['artworkPath'] . " alt='cover'>
                    <div class='artworkInfo'>" . $row['title'] . "</div>
                </span>
              </div>";
    }
    ?>

</div>