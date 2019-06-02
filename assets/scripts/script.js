var currentPlaylist = [];
var audioElement;

function Audio() {
    this.audio = document.createElement("audio");
    this.currentlyPlaying;

    this.setTrack = function(song) {
        this.audio.src = song.path;
        this.currentlyPlaying = song;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }
}