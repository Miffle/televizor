<?php

?>
<script>

    socket.addEventListener('open', function (event) {
        socket.send(JSON.stringify({event: 'in_room_register', user, room_url}));
        socket.send(JSON.stringify({event: 'fetch_chat_message', room_url}));
        socket.send(JSON.stringify({event: 'fetch_users_message', room_url}));
        socket.send(JSON.stringify({event: 'sync_with_host', room_url}));
    });

    // Получаем сообщения от сервера
    socket.addEventListener('message', function (event) {
        const data = JSON.parse(event.data);
        // Обработка сообщений от сервера
        switch (data.event) {
            case 'fetch_message':
                ChatMessageFetch(data.message);
                break;
            case "usersFetch":
                users_fetch(data.users);
                break;
        }
    });

    function ChatMessageFetch(messages) {
        var filteredMessages = messages.filter(function (message) {
            return message !== ',';
        });

        // Преобразуем массив сообщений в строку, разделяя их переносом строки
        var formattedMessagesString = filteredMessages.join('\n');

        chatMessages.innerHTML = formattedMessagesString;
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function users_fetch(users) {
        const UserList = document.getElementById("user_in_room");
        while (UserList.firstChild) {
            UserList.removeChild(UserList.firstChild);
        }

        for (var i = 0; i < users.length; i++) {
            var username = users[i];
            var li = document.createElement("li");
            li.textContent = username;
            UserList.appendChild(li);
        }
    }

    function sendMessage() {
        const message = messageInput.value.trim();
        if (lengthCheck(message) && emptyCheck(message)) {
            socket.send(JSON.stringify({event: "send_chat_message", message, room_url, user}));
            messageInput.value = "";
            send_question();
        } else {
            alert("Текст слишком длинный - " + message.length + " сиволов");
        }
    }



    let message = ""; // Инициализируем переменную message вне обработчика событий
    messageInput.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            message = messageInput.value.trim()
            if (lengthCheck(message) && emptyCheck(message)) {
                sendMessage();
            }
        }
    })

    messageInput.addEventListener("input", function () {
        clearTimeout(15);
        message = messageInput.value.trim(); // Обновляем message при изменении содержимого поля ввода
        if (!lengthCheck(message)) {
            messageInput.style.borderColor = "red";
        } else {
            messageInput.style.borderColor = "1px solid var(--border-color)";
        }

    });

    function lengthCheck(message) {
        return message.length < 3000;

    }

    function emptyCheck(message) {
        return message !== "";

    }

    function send_message_question() {
        socket.send(JSON.stringify({event: 'fetch_chat_message', room_url}))
    }

    function send_user_question() {
        socket.send(JSON.stringify({event: 'fetch_users_message', room_url}))
    }

    setInterval(send_message_question, 1000);
    setInterval(send_user_question, 5000);

    window.addEventListener("beforeunload", function () {
        socket.send(JSON.stringify({event: 'user_quit', user, room_url}));
    });

</script>