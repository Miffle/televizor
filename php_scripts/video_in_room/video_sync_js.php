<?php

?>

<script>
    // Событие получения сообщения от сервера
    socket.addEventListener('message', function (event) {
        const data = JSON.parse(event.data);

        // Обработка сообщений от сервера
        switch (data.event) {
            case 'videoData':
                sync_with_host(data.VideoData);
                break;
            // Другие обработчики сообщений от сервера
        }
    });

    // Обработчик события паузы видео
    StandardPlayer.addEventListener('pause', function () {
        updateVideoStatus(1);
    });

    // Обработчик события воспроизведения видео
    StandardPlayer.addEventListener('play', function () {
        updateVideoStatus(0);
        setInterval(sendVideoTime, 2000);
    });

    // Функция отправки статуса видео на сервер
    function updateVideoStatus(status) {
        socket.send(JSON.stringify({event: 'update_status', room_url, status, user}));
    }

    // Функция отправки текущего времени видео на сервер
    function sendVideoTime() {
        const time = StandardPlayer.currentTime;
        socket.send(JSON.stringify({event: 'update_time', room_url, time, user}));
    }

    // Функция отправки источника видео на сервер
    function sendVideoSrc(src) {
        socket.send(JSON.stringify({event: 'update_src', room_url, src, user}));
    }

    // Обработчик изменения статуса видео от сервера

    function sync_with_host(videoData) {
        if (!StandardPlayer.hidden) {
            if (videoData[0]['creator'] !== user) {
                handleVideoTime(videoData[0]['time']);
                handleVideoSrc(videoData[0]['src']);
            }
            handleVideoStatus(videoData[0]['status']);
        } else {

        }
    }

    function handleVideoStatus(status) {
        if (status === "0") {
            StandardPlayer.play();
        } else {
            StandardPlayer.pause();
        }
    }

    // Обработчик изменения времени видео от сервера
    function handleVideoTime(time) {
        const timeDifference = Math.abs(StandardPlayer.currentTime - time);
        const timeThreshold = 1;
        if (timeDifference > timeThreshold) {
            // Изменяем время видео только если разница больше порогового значения
            StandardPlayer.currentTime = time;
        }
    }

    // Обработчик изменения источника видео от сервера
    function handleVideoSrc(src) {
        if (StandardPlayer.src !== src && src !== null) {
            StandardPlayer.src = src;
        }

    }
    function handleYTVideoStatus(status) {
        if (status === "0") {
            YoutubePlayer.play();
        } else {
            YoutubePlayer.pause();
        }
    }

    // Обработчик изменения времени видео от сервера
    function handleYTVideoTime(time) {
        const timeDifference = Math.abs(YoutubePlayer.currentTime - time);
        const timeThreshold = 1;
        if (timeDifference > timeThreshold) {
            // Изменяем время видео только если разница больше порогового значения
            YoutubePlayer.currentTime = time;
        }
    }

    // Обработчик изменения источника видео от сервера
    function handleYTVideoSrc(src) {
        if (YoutubePlayer.src !== src && src !== null) {
            YoutubePlayer.src = src;
        }

    }

    function send_question() {
        socket.send(JSON.stringify({event: 'sync_with_host', room_url}))
    }

    setInterval(send_question, 2000)
</script>