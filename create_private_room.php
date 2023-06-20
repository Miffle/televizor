<?php
session_start();
// Подключение к базе данных
include "database/dbase_connect.php";
$user = $_SESSION['username'];
$plusCheckBase = connecting();
$plus = mysqli_query($plusCheckBase, "SELECT TelevizorPlus FROM `users` WHERE username = '$user'");
mysqli_close($plusCheckBase);


if ($user == null) {
    header("Location: authorization.php");
} elseif ($plus == 0) {
    header("Location: ..");

} else {
// Функция для генерации уникального URL комнаты
    include "php_scripts/roomUrlGenerating.php";
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
        header("Location: watching.php?url=$roomUrl");
        exit();
    }
}