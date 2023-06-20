<?php
session_start();
include "dbase_connect.php";
$dbase = connecting();

$login = $_POST['login'];
$passwd = $_POST['password'];
$email = $_POST['email'];
if ($login != '' and $passwd != '' and $email != '') {
    mysqli_query($dbase, "INSERT INTO `users` (`id`, `username`, `password`, `email`, `watching_room_url`) VALUES (NULL, '$login', '$passwd', '$email', NULL);");
    $_SESSION["username"] = $_POST["login"];
    header('location: /create_room.php');
}else {
    header("location: ..");
    echo "Поля не должны быть пустыми";
}

mysqli_close($dbase);
