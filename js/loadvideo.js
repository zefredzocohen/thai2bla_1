var player;

    function onYouTubePlayerAPIReady() {
        player = new YT.Player('video', {
          events: {
            'onReady': onPlayerReady
          }
        });
    }
    function onPlayerReady(event) {
      // bind events
        var playButton = document.getElementById("btn-video");
        var pauseButton = document.getElementById("btn-pause");
        playButton.addEventListener("click", function() {
          player.playVideo();
          playButton.style.visibility = 'hidden';
          pauseButton.style.visibility = 'visible';
        });

        var pauseButton = document.getElementById("btn-pause");
        pauseButton.addEventListener("click", function() {
          player.pauseVideo();
        playButton.style.visibility = 'visible';  
//        playButton.css('visibility','visible');
          
//          pauseButton.css('visibility','hidden');
          pauseButton.style.visibility = 'hidden';
        });

    }