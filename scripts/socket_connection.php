<?php
session_start();
?>
<script>
    const socket = new WebSocket("ws://127.0.0.1:8080/watching.php"); // Замените "ws://127.0.0.1:8080" на URL вашего WebSocket сервера
    // Событие открытия WebSocket соединения
    socket.addEventListener("open", function () {
        <?php if($_SESSION["username"] != ""):?>
        themeFetching();
        <?php endif;?>
    })
</script>
