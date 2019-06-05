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
        updateVolumeProgressBar(audioElement.audio);

        $(".playbackBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(event) {
            if (mouseDown) {
                calculateOffsetPlaybackBar(event, this);
            }
        });

        $(".playbackBar .progressBar").mouseup(function() {
            calculateOffsetPlaybackBar(event, this);
        });

        $(".volumeBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function(event) {
            if (mouseDown) {
                calculateOffsetVolumeBar(event, this);
            }
        });

        $(".volumeBar .progressBar").mouseup(function() {
            calculateOffsetVolumeBar(event, this);
        });

        $("#nowPlayingBarContainer").on("mousedown mousemove touchdown touchmove", function(event) {
            event.preventDefault();
        });
    });

    $(document).mouseup(function() {
        mouseDown = false;
    });

    function nextSong() {
        if (repeatMode) {
            audioElement.setTime(0);
            playSong();
            return;
        }

        if (shuffle) {
            var randomIndex = Math.floor(Math.random() * currentPlaylist.length);
            songIndex = randomIndex;
            setTrack(currentPlaylist[randomIndex], currentPlaylist, true);
            playSong();
            return;
        }
        songIndex = songIndex == currentPlaylist.length - 1 ? 0 : songIndex + 1;
        setTrack(currentPlaylist[songIndex], currentPlaylist, true);
    }

    function previousSong() {
        songIndex = songIndex == 0 ? currentPlaylist.length - 1 : songIndex - 1;
        setTrack(currentPlaylist[songIndex], currentPlaylist, true);
    }

    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var volumeImage = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src", "assets/images/icons/" + volumeImage);
    }

    function setRepeat() {
        repeatMode = !repeatMode;
        var repeatImage = repeatMode ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src", "assets/images/icons/" + repeatImage);
    }

    function setShuffle() {
        shuffle = !shuffle;
        var shuffleImage = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + shuffleImage);
    }

    function calculateOffsetPlaybackBar(mouse, progressBar) {
        var percentage = mouse.offsetX / $(".playbackBar .progressBar").width() * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    function calculateOffsetVolumeBar(mouse, progressionBar) {
        var percentage = mouse.offsetX / $(".volumeBar .progressBar").width();
        if (percentage >= 0 && percentage <= 1) {
            audioElement.setVolume(percentage);
        }
    }

    function setTrack(id, newPlaylist, play) {
        currentPlaylist = newPlaylist;
        songIndex = currentPlaylist.indexOf(id);

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

            audioElement.setTrack(song);
            if (play) {
                playSong();
            }
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
                    <button class="controlButton shuffle" title="shuffle" onclick="setShuffle()">
                        <img src="assets/images/icons/shuffle.png" alt="shuffle">
                    </button>

                    <button class="controlButton previous" title="previous" onclick="previousSong()">
                        <img src="assets/images/icons/previous.png" alt="previous">
                    </button>

                    <button class="controlButton play" title="play" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="play">
                    </button>

                    <button class="controlButton pause" title="pause" onclick="pauseSong()" style="display: none;">
                        <img src="assets/images/icons/pause.png" alt="pause">
                    </button>

                    <button class="controlButton next" title="next" onclick="nextSong()">
                        <img src="assets/images/icons/next.png" alt="next">
                    </button>

                    <button class="controlButton repeat" title="repeat" onclick="setRepeat()">
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
                <button class="controlButton volume" title="Volume button" onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="volume">
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