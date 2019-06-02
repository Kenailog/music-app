<?php

$playlist = $conn->query("SELECT id FROM songs ORDER BY RAND() LIMIT 10");

while ($row = $playlist->fetch_assoc()) {
    $array[] = $row['id'];
}

$json_array = json_encode($array);

?>

<script>
    $(document).ready(function() {
        currentPlaylist = <?= $json_array ?>;
        audioElement = new Audio();
        setTrack(currentPlaylist[0], currentPlaylist, false);
    });

    function setTrack(id, newPlaylist, play) {
        $.post("includes/handlers/ajax/getSongJSON.php", {
            songId: id
        }, function(data) {
            var song = JSON.parse(data);
            $(".trackName span").text(song.title);

            $.post("includes/handlers/ajax/getArtistJSON.php", {
                artistId: song.artist
            }, function(data) {
                var artist = JSON.parse(data);
                $(".artistName span").text(artist.name);
            });

            $.post("includes/handlers/ajax/getAlbumJSON.php", {
                albumId: song.album
            }, function(data) {
                var album = JSON.parse(data);
                $(".albumLink img").attr("src", album.artworkPath);
            });

            console.log(song);
            audioElement.setTrack(song);

        });
    }

    function playSong() {

        if (audioElement.audio.currentTime == 0) {
            $.post("includes/handlers/ajax/updatePlays.php", {
                songId: audioElement.currentlyPlaying.id
            });
        }

        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    function pauseSong() {
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        audioElement.pause();
    }
</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">

        <div id="left">
            <span class="albumLink">
                <img src="" alt="Album art">
            </span>

            <div class="trackInfo">
                <span class="trackName">
                    <span></span>
                </span>
                <span class="artistName">
                    <span></span>
                </span>
            </div>
        </div>

        <div id="middle">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="shuffle">
                        <img src="assets/images/icons/shuffle.png" alt="shuffle">
                    </button>

                    <button class="controlButton previous" title="previous">
                        <img src="assets/images/icons/previous.png" alt="previous">
                    </button>

                    <button class="controlButton play" title="play" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="play">
                    </button>

                    <button class="controlButton pause" title="pause" onclick="pauseSong()" style="display: none;">
                        <img src="assets/images/icons/pause.png" alt="pause">
                    </button>

                    <button class="controlButton next" title="next">
                        <img src="assets/images/icons/next.png" alt="next">
                    </button>

                    <button class="controlButton repeat" title="repeat">
                        <img src="assets/images/icons/repeat.png" alt="repeat">
                    </button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">00:00</span>
                    <div class="progressBar">
                        <div class="progressBarBackground">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">00:00</span>
                </div>

            </div>
        </div>

        <div id="right">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume button">
                    <img src="assets/images/icons/volume.png" alt="">
                </button>

                <div class="progressBar">
                    <div class="progressBarBackground">
                        <div class="progress"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>