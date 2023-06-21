<?php
?>
<script>
    socket.addEventListener('message', function (event) {
        const data = JSON.parse(event.data);
        // Обработка сообщений от сервера
        switch (data.event) {
            case "openRooms":
                OpenRoomOutput(data.rooms);
                break;
        }
    });

    function OpenRoomOutput(rooms) {

        if (rooms.length === 0) {
            const h1 = document.createElement("h1");
            h1.innerText = "Открытых комнат пока что нет";
            h1Div.appendChild(h1);
        } else {
            const h1 = document.createElement("h1");
            h1.innerText = "Открытые комнаты:";
            h1Div.appendChild(h1);
            for (var i = 0; i < rooms.length; i++) {
                const preview = document.createElement("img");
                const creator = document.createElement("p");
                const div = document.createElement("div");
                preview.className = "preview";
                creator.className = "creator";
                div.className = "card";
                div.id = "card" + i;
                preview.src = "source_files/icons/videoPoster.jpg";
                creator.innerText = rooms[i]["creator"];
                div.appendChild(preview);
                div.appendChild(creator);
                roomsDiv.appendChild(div);
            }
            for (i = 0; i < rooms.length; i++) {
                const card = document.getElementById("card" + i)
                const room_url = rooms[i]["room_url"];
                card.addEventListener("click", function () {
                    window.location.href = ("/watching.php?url=" + room_url)
                })
            }
        }

    }
</script>
