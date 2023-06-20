<?php
?>
<script>
    themeChangeBtn.addEventListener("click", function () {
        pageBody.classList.toggle("light-theme");
        let theme = pageBody.classList[1];
        console.log(theme);
        if (theme === "light-theme") {
            let themeId = 1;
            socket.send(JSON.stringify({event: 'theme_changing', themeId, user}));
        } else {
            let themeId = 0;
            socket.send(JSON.stringify({event: 'theme_changing', themeId, user}));
        }
    })
    function themeFetching(){
        socket.send(JSON.stringify({event: 'theme_fetch', user}));
        socket.addEventListener('message', function (event) {
            const data = JSON.parse(event.data);

            // Обработка сообщений от сервера
            switch (data.event) {
                case 'theme':
                    theme_applying(data.current_theme);
                    break;
                // Другие обработчики сообщений от сервера
            }
            function theme_applying(theme){
                console.log(theme);
                if(theme === "1"){
                    pageBody.classList.toggle("light-theme");
                }
            }
        });
    }
</script>
