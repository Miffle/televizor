<?php
session_start();
if ($_SESSION['username'] == null) {
    header("location: authorization.php");
}
if (!$_GET['url']) {
    header("location: ..");
}

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Televizor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://anijs.github.io/lib/anicollection/anicollection.css">
    <link rel="stylesheet" href="css/watchingPageMain.css">
    <link rel="icon" href="source_files/icons/television_icon.png" type="image/x-icon">

</head>
<body class="page">
<header data-anijs="if: onRunFinished, on: $AniJSNotifier, do: bounceInDown animated">
    <p class="title" id="title">Televizor</p>
    <div class="user_title">
        <p class="user_hello">Привет <?php echo $_SESSION["username"] ?>!</p>
        <button class="logout_btn" onclick="location.href='database/logout.php'">Выйти</button>
    </div>
</header>
<div>
    <div class="container">
        <div class="watching_selection" data-anijs="if: onRunFinished, on: $AniJSNotifier, do: bounceIn animated">
            <div class="video_container">
                <video controls id="video" preload="none" poster="source_files/icons/poster.png"
                       src="source_files/films/1.mp4"></video>
            </div>
            <div class="user_in_group_container">
                <p class="usersTitle">В чате:</p>
                <ul class="users_in_group" id="user_in_room">
                </ul>
            </div>
            <div class="chat" data-anijs="if: onRunFinished, on: $AniJSNotifier, do: bounceInUp animated">
                <div class="MessagesAndControls">
                    <p class="chatTitle">Чат:</p>
                    <div id="chat_container">
                        <div id="chat_messages"></div>
                    </div>
                    <div class="chat_controls">
                        <input type="text" id="message_input" placeholder="Введите сообщение">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
include "php_scripts/variables.php";
include "php_scripts/socket_connection.php";
include "php_scripts/themeChanging.php";
include "php_scripts/video_in_room/video_sync_js.php";
include "php_scripts/chat_scripts/room_and_users_js_functions.php";
include "php_scripts/video_in_room/video_src_changing.php";
include "php_scripts/watchingPageScripts.php";
?>
<script type="text/javascript" src="js/anijs-master/dist/anijs-min.js"></script>
</body>
</html>

