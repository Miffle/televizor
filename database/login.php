<?php
session_start();

include "dbase_connect.php";
$dbase = connecting();

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $passwd = $_POST['password'];

    $query = mysqli_prepare($dbase, "SELECT id FROM `users` WHERE `username` = ? AND `password` = ?");
    mysqli_stmt_bind_param($query, "ss", $login, $passwd);
    mysqli_stmt_execute($query);
    mysqli_stmt_store_result($query);
    $user_id = mysqli_stmt_num_rows($query);

    if ($user_id > 0) {
        $_SESSION["username"] = $_POST["login"];
        header('Location: ..');
        exit();
    } else {
        header("Location: ../authorization.php");
        exit();
    }
}

mysqli_close($dbase);
?>
