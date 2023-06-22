<?php
session_start();
include "dbase_connect.php";
$dbase = connecting();

$login = $_POST['login'];
$passwd = $_POST['password'];
$passwdDub = $_POST['dubPassword'];
$email = $_POST['email'];
if ($login != '' and $passwd != '' and $passwdDub === $passwd and $email != '') {
    mysqli_query($dbase, "INSERT INTO `users` (`id`, `username`, `password`, `email`, `watching_room_url`) VALUES (NULL, '$login', '$passwd', '$email', NULL);");
    $_SESSION["username"] = $_POST["login"];
    header('location: ..');
}
else {
    header("location: ..");
    echo "Поля не должны быть пустыми";
}

mysqli_close($dbase);
