var currentPlaylist = [];
var audioElement;
var mouseDown = false;

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - minutes * 60;
    var zero = seconds < 9 ? "0" : "";
    return minutes + ':' + zero + seconds;
}

function updateProgressBar(audio) {
    var progress = (audio.currentTime / audio.duration) * 100;
    $('.playbackBar .progress').css('width', progress + '%');
}

function Audio() {
    this.audio = document.createElement("audio");
    this.currentlyPlaying;

    this.audio.addEventListener('canplay', function() {
        $('.progressTime.remaining').text(formatTime(this.duration));
    });

    this.audio.addEventListener('timeupdate', function() {
        $('.progressTime.current').text(formatTime(this.currentTime));
        $('.progressTime.remaining').text(formatTime(this.duration - this.currentTime));
        updateProgressBar(this);
    });

    this.setTime = function(seconds) {
        audioElement.audio.currentTime = seconds;
    }

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