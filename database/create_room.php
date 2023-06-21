<?php
session_start();
// Подключение к базе данных
if ($_SESSION['username'] == null){
    header("Location: ..");
}
else {
// Функция для генерации уникального URL комнаты
    include "dbase_connect.php";
    include "../scripts/roomUrlGenerating.php";

    function room_register($generatedUrl): void
    {
        $dbase = connecting();
        $roomCreator = $_SESSION["username"];
        $roomOpenStatus = "Open";
        mysqli_query($dbase, "INSERT INTO `rooms` (`id`, `room_url`, `creator`, `roomOpen`) VALUES (NULL, '$generatedUrl', '$roomCreator', '$roomOpenStatus');");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $roomUrl = generateRoomUrl();
        room_register($roomUrl);
        header("Location: ../watching.php?url=$roomUrl");
        exit();
    }
}