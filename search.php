<?php
include_once("includes/includedFiles.php");

$search = isset($_GET['search']) ? urldecode($_GET['search']) : "";
$search = htmlspecialchars($search);

?>

<div class="searchContainer">
    <h3>Search for artists, songs and albums</h3>
    <input class="searchInput" type="text" value="<?php echo $search; ?>" placeholder="Type..." onfocus="this.value = this.value">
</div>

<script>
    $(".searchInput").focus();
    $(function() {
        $(".searchInput").keyup(function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                var value = $(".searchInput").val();
                loadContent("search.php?search=" + value);
            }, 1000);
        })
    })
</script>

<?php
if ($search === "") {
    return;
}
?>

<div class="tracklistContainer borderBottom">
    <h2>Songs</h2>
    <ul class="tracklist">

        <?php
        $query = $conn->query("SELECT id FROM songs WHERE title LIKE '%$search%' LIMIT 10") or die($conn->error);

        if ($query->num_rows == 0) {
            echo "<span class='noResult'>No matches found</span>";
        }

        $songs = array();
        $i = 1;
        while ($row = $query->fetch_assoc()) {
            if ($i > 15) {
                break;
            }

            array_push($songs, $row["id"]);
            $song = new Song($row["id"], $conn);
            $artist = $song->getArtist();

            ?>
            <li class='tracklistRow'>
                <div class='trackCount'>
                    <img class='playButton' src='assets/images/icons/play-white.png' alt='play' onclick="setTrack(<?= strval($row['id']) ?>, tempPlaylist, true)">
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

<div class="artistsContainer borderBottom">
    <h2>Artists</h2>

    <?php
    $query = $conn->query("SELECT id FROM artists WHERE name LIKE '%$search%' LIMIT 10") or die($conn->error);

    if ($query->num_rows == 0) {
        echo "<span class='noResult'>No matches found</span>";
    }

    while ($row = $query->fetch_assoc()) {
        $artist = new Artist($conn, $row['id']);

        ?>
        <div class="searchResultRow">
            <div class="artistName">
                <span role="link" tabindex="0" onclick='loadContent("artist.php?id=<?php echo $row["id"]; ?>")'><?php echo $artist->getName(); ?></span>
            </div>
        </div>
    <?php
}
?>
</div>

<div class="gridViewContainer">
    <h2>Albums</h2>
    <?php
    $albums = $conn->query("SELECT * FROM albums WHERE title LIKE '%$search%'") or die($conn->error);

    if ($albums->num_rows == 0) {
        echo "<span class='noResult'>No matches found</span>";
    }

    while ($row = $albums->fetch_array()) {
        echo " <div class='gridViewItem'>
         <span role='link' tabindex ='0' onclick='loadContent(\"album.php?id=" . $row['id'] . "\") '>
         <img src =" . $row['artworkPath'] . " alt ='cover'>
         <div class='artworkInfo'>" . $row['title'] . " </div>
          </span>
          </div>";
    }
    ?>

</div>