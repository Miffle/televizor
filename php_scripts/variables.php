<?php
?>
<script>
    const standardPlayerBtn = document.getElementById("standardPlayerBtn");
    const pageBody = document.querySelector(".page")
    const roomsDiv = document.getElementById("openRoom");
    const h1Div = document.getElementById("h1");
    const title = document.getElementById("title");
    const user = "<?php echo $_SESSION['username'] ?>";
    const StandardPlayer = document.getElementById('video');
    const room_url = "<?php echo $_GET['url'] ?>";
    const messageInput = document.getElementById("message_input");
    const chatMessages = document.getElementById("chat_messages");
    const chatContainer = document.getElementById("chat_container");
    const src_input = document.getElementById("src_input");
    const src_change_btn = document.getElementById("src_change");
    const themeChangeBtn = document.querySelector(".user_hello");
</script>
