var currentPlaylist = [];
var songIndex;
var audioElement;
var mouseDown = false;
var repeatMode = false;
var shuffle = false;

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - minutes * 60;
    var zero = seconds < 9 ? "0" : "";
    return minutes + ':' + zero + seconds;
}

function updateTimeProgressBar(audio) {
    var progress = (audio.currentTime / audio.duration) * 100;
    $('.playbackBar .progress').css('width', progress + '%');
}

function updateVolumeProgressBar(audio) {
    $('.volumeBar .progress').css('width', audio.volume * 100 + '%');
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
        updateTimeProgressBar(this);
    });

    this.audio.addEventListener('volumechange', function() {
        updateVolumeProgressBar(this);
    })

    this.audio.addEventListener('ended', function() {
        nextSong();
    });

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }

    this.setVolume = function(volume) {
        this.audio.volume = volume;
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