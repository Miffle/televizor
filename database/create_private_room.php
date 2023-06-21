<?php
session_start();
// Подключение к базе данных
include "dbase_connect.php";
$user = $_SESSION['username'];
$plusCheckBase = connecting();
$plusResult = mysqli_query($plusCheckBase, "SELECT TelevizorPlus FROM `users` WHERE username = '$user'");
$plus = mysqli_fetch_assoc($plusResult);
mysqli_close($plusCheckBase);

if ($user == null or $plus["TelevizorPlus"] == 0) {
    header("Location: ..");
} else {
// Функция для генерации уникального URL комнаты
    include "../scripts/roomUrlGenerating.php";
    function private_room_register($generatedUrl): void
    {
        $dbase = connecting();
        $roomCreator = $_SESSION["username"];
        mysqli_query($dbase, "INSERT INTO `rooms` (`id`, `room_url`, `creator`, `roomOpen`) VALUES (NULL, '$generatedUrl', '$roomCreator', 'Private');");
        mysqli_close($dbase);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $roomUrl = generateRoomUrl();
        private_room_register($roomUrl);
        header("Location: ../watching.php?url=$roomUrl");
        exit();
    }
}