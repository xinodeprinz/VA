var form = document.getElementById('form');
var videoProgress = document.getElementById('video-progress');

let player;

async function onYouTubeIframeAPIReady() {
    // Fetching video from server.
    const res = await fetch('/random/video');
    const video = await res.json();

    player = new YT.Player('player', {
        height: 500,
        width: '100%',
        videoId: video.url,
        playerVars: {
            autoplay: 1,
            playersinline: 1,
            controls: 0,
            disablekb: 1,
        },
        events: {
            onStateChange,
        },
    });

    function onStateChange(e) {

        const idInput = createInput(video.id);
        if (!form.querySelector('#v-id')) {
            form.appendChild(idInput);
        }
        if (e.data == 0) {
            // Video has finished playing
            form.submit();
        }
    }

    function createInput(videoId) {
        const idInput = document.createElement('input');
        idInput.setAttribute('type', 'number');
        idInput.setAttribute('id', 'v-id');
        idInput.setAttribute('name', 'id');
        idInput.setAttribute('hidden', true);
        idInput.setAttribute('value', videoId);
        return idInput;
    }

    setInterval(() => {
        const totalLength = player.getDuration();
        const playedLength = player.getCurrentTime();
        const progress = Math.round((playedLength / totalLength) * 100);
        videoProgress.innerText = `${progress}%`;
        videoProgress.setAttribute('aria-valuenow', progress);
        videoProgress.setAttribute('style', `width: ${progress}%`)
    }, 1000);
}