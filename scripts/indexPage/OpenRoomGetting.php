<?php if ($_SESSION["username"] != ""): ?>
<script>
    socket.addEventListener('open', function (event) {
        socket.send(JSON.stringify({event: 'OpenRoomGet', user}));
    });
</script>
<?php endif;?>