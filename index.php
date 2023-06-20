<?php
session_start();

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Televizor</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="css/indexPageMain.css">
<!--    <link rel="stylesheet" type="text/css" href="css/colors.css">-->
<!--    <link rel="stylesheet" type="text/css" href="css/desktop/head.css">-->
<!--    <link rel="stylesheet" type="text/css" href="css/desktop/main_page_style.css">-->
<!--    <link rel="stylesheet" type="text/css" href="css/desktop/roomsCard.css">-->
<!--    <link rel="stylesheet" type="text/css" href="css/desktop/authPopup.css">-->
    <link rel="stylesheet" href="http://anijs.github.io/lib/anicollection/anicollection.css">
    <link rel="icon" href="source_files/icons/television_icon.png" type="image/x-icon">

</head>
<body class="page">
<header data-anijs="if: onRunFinished, on: $AniJSNotifier, do: bounceInDown animated">
    <p class="title">Televizor</p>
    <?php
    $logout_href = '&quot;database/logout.php&quot;';
    $auth_href = "&quot;authorization.php&quot;";
    if ($_SESSION['username'] != null) {
        echo '<div class="user_title">';
        echo '<p class="user_hello">Привет ' . $_SESSION["username"] . '!</p>';
        echo '<button class="logout_btn" onclick="location.href=' . $logout_href . '">Выйти</button>';
        echo '</div>';
    } else {
        echo '<button class="login_btn" onclick="login()">Войти</button>';
    }
    ?>
</header>
<h1>Кнопки создания комнат:</h1>
<div class="creating_rooms">
    <form action="create_room.php" method="post">
        <input class="room_create_input" type="submit" value="Создать комнату">
    </form>
    <form action="create_private_room.php" method="post">
        <input class="private_room_create_input" type="submit" value="Создать приватную комнату">
    </form>
</div>
<div id="h1"></div>
<div id="openRoom"></div>
<div class="hide" id="hide" onclick="hideForms()"></div>
<div class="window" id="window">
    <form class="authorization_form" id="authorization_form" action="database/login.php" method="post">
        <h3>Авторизация</h3>
        <p>Логин</p>
        <input type="text" name="login" placeholder="Обязательное поле">
        <p>Пароль</p>
        <input type="password" name="password" placeholder="Обязательное поле"> <br><br>
        <button class="auth_btn" type="submit">Войти</button>
        <button class="reg_switch" id="reg_switch" type="button" onclick="registration()">Зарегистрироваться</button>
    </form>
    <form class="registration_form hidden" id="registration_form" action="database/registration.php" method="post">
        <h3>Регистрация</h3>
        <p>Логин</p>
        <input type="text" name="login" placeholder="Обязательное поле">
        <p>Почта</p>
        <input type="email" name="email" placeholder="Обязательное поле">
        <p>Пароль</p>
        <input type="password" name="password" placeholder="Обязательное поле">
        <br><br>
        <button class="reg_btn" type="submit">Зарегистрироваться</button>
        <button class="reg_switch" id="auth_switch" type="button" onclick="loginForm()">Войти</button>
    </form>
</div>
<?php
include "php_scripts/variables.php";
include "php_scripts/socket_connection.php";
include "php_scripts/mainPageScripts.php";
include "php_scripts/themeChanging.php";
include "php_scripts/authPopup.php";
?>
<script>
    socket.addEventListener('open', function (event) {
        socket.send(JSON.stringify({event: 'OpenRoomGet', user}));
    });

</script>
<script type="text/javascript" src="js/anijs-master/dist/anijs-min.js"></script>
</body>
</html>