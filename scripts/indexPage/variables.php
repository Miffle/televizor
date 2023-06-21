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
</script>
