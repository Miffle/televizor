<?php
?>
<script>
    const pageBody = document.querySelector(".page")
    const roomsDiv = document.getElementById("openRoom");
    const h1Div = document.getElementById("h1");
    const title = document.getElementById("title");
    <?php if($_SESSION["username"]!= ""):?>
    const user = "<?php echo $_SESSION['username'] ?>";
    const themeChangeBtn = document.querySelector(".user_hello");
    <?php endif;?>
    const passwd = document.getElementById("PasswordToRegistration");
    const passwdDub = document.getElementById("DubPasswordToRegistration");
    const regBtn = document.getElementById("regBtn");
    const regLogin = document.getElementById("LoginToRegistration");
    const regEmail = document.getElementById("email");
    const logLogin = document.getElementById("LoginToAuth");
    const logPassword = document.getElementById("passwordToAuth");
    const logBtn = document.getElementById("authBtn");
</script>
