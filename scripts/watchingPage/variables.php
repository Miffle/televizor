<?php
?>
<script>
    const pageBody = document.querySelector(".page");
    const user = "<?php echo $_SESSION['username'] ?>";
    const StandardPlayer = document.getElementById('video');
    const room_url = "<?php echo $_GET['url'] ?>";
    const messageInput = document.getElementById("message_input");
    const chatMessages = document.getElementById("chat_messages");
    const chatContainer = document.getElementById("chat_container");
    const themeChangeBtn = document.querySelector(".user_hello");
</script>
