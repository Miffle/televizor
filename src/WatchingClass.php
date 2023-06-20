<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require "../database/dbase_connect.php";
session_start();

class WatchingClass implements MessageComponentInterface
{
    protected \mysqli|false $dbase;
    protected \SplObjectStorage $clients;


    public function __construct()
    {
        $this->dbase = \connecting();
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        // Обработка сообщений от клиента
        switch ($data['event']) {
            case 'sync_with_host':
                $this->handleSyncVideo($from, $data['room_url']);
                break;
            case 'update_status':
                $this->handleUpdateStatus($from, $data['room_url'], $data['status']);
                break;
            case 'update_time':
                $this->handleUpdateTime($from, $data['room_url'], $data['time'], $data['user']);
                break;
            case 'update_src':
                $this->handleUpdateSrc($from, $data['room_url'], $data['src'], $data['user']);
                break;
            case 'fetch_chat_message':
                $this->chatMessageFetch($from, $data['room_url']);
                break;
            case 'send_chat_message':
                $this->chatMessageSend($from, $data['message'], $data['room_url'], $data['user']);
                break;
            case 'fetch_users_message':
                $this->usersFetch($from, $data['room_url']);
                break;
            case 'in_room_register':
                $this->in_room_register($from, $data['user'], $data['room_url']);
                break;
            case 'OpenRoomGet':
                $this->OpenRoomGetting($from, $data['user']);
                break;
            case 'theme_changing':
                $this->themeChanging($from, $data['themeId'], $data['user']);
                break;
            case 'theme_fetch':
                $this->themeFetching($from, $data['user']);
                break;
            case 'user_quit':
                $this->user_quit($from, $data['user'], $data['room_url']);
                break;
            // Другие обработчики сообщений от клиента
        }
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e): void
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }


    protected function handleSyncVideo(ConnectionInterface $conn, $roomUrl): void
    {
        $videoData = array();
        $videoSpecifications = \mysqli_query($this->dbase, "SELECT video_time, video_src, video_status, creator FROM `rooms` WHERE `room_url` = '$roomUrl'");

        while ($row = \mysqli_fetch_assoc($videoSpecifications)) {
            $videoData[] = array(
                'time' => $row['video_time'],
                'src' => $row['video_src'],
                'status' => $row['video_status'],
                'creator' => $row['creator']
            );
        }
        $responseData = [
            "event" => 'videoData',
            'VideoData' => $videoData
        ];
        $conn->send(json_encode($responseData));
    }


    protected function handleUpdateStatus(ConnectionInterface $conn, $roomUrl, $status): void
    {
        \mysqli_query($this->dbase, "UPDATE `rooms` SET video_status = '$status' WHERE `room_url` = '$roomUrl'");


    }

    protected function chatMessageFetch(ConnectionInterface $conn, $roomUrl): void
    {
        $messages = \mysqli_query($this->dbase, "SELECT * FROM `chat_messages` WHERE `room_url` = '$roomUrl'");
        $message = array(
            "event" => "fetch_message",
        );
        $AllMessages = array();
        while ($row = mysqli_fetch_assoc($messages)) {
            $message_sender = $row['message_sender'];
            $message_text = $row['message_text'];
            $AllMessages[] = "<u><b>" . $message_sender . "</b></u>" . ": " . $message_text . "<br>";

        }
        $message['message'] = $AllMessages;
        $conn->send(json_encode($message));

    }

    protected function chatMessageSend(ConnectionInterface $conn, $message, $roomUrl, $user): void
    {
        mysqli_query($this->dbase, "INSERT INTO `chat_messages` (`id`, `message_sender`, `message_text`, `room_url`) VALUES (NULL, '$user', '$message', '$roomUrl')");

    }

    protected function handleUpdateTime(ConnectionInterface $conn, $roomUrl, $time, $user): void
    {
        \mysqli_query($this->dbase, "UPDATE `rooms` SET video_time = '$time' WHERE `room_url` = '$roomUrl' AND `creator` = '$user'");

    }

    protected function handleUpdateSrc(ConnectionInterface $conn, $roomUrl, $src, $user): void
    {
        \mysqli_query($this->dbase, "UPDATE `rooms` SET video_src = '$src' WHERE `room_url` = '$roomUrl' AND `creator` = '$user'");

    }

    protected function usersFetch(ConnectionInterface $conn, $roomUrl): void
    {
        $users = \mysqli_query($this->dbase, "SELECT `username` FROM `users` WHERE `watching_room_url` = '$roomUrl'");
        $ResponseUsernames = array(
            "event" => "usersFetch"
        );
        $usernames = array();
        while ($row = mysqli_fetch_assoc($users)) {
            $username = $row['username'];
            $usernames[] = $username;
        }
        $ResponseUsernames['users'] = $usernames;
        $conn->send(json_encode($ResponseUsernames));

    }

    protected function in_room_register(ConnectionInterface $conn, $user, $roomUrl): void
    {
        $room = mysqli_query($this->dbase, "SELECT EXISTS(SELECT room_url FROM `rooms` WHERE `room_url` = '$roomUrl') ");

        $usersInRoom = $this->getUsersInRoom($roomUrl) + 1;
        if ($room) {
            mysqli_query($this->dbase, "UPDATE `users` SET watching_room_url = '$roomUrl' WHERE username = '$user'");
            mysqli_query($this->dbase, "UPDATE `rooms` SET users_in_room = $usersInRoom WHERE room_url='$roomUrl'");
            $this->roomOpening($roomUrl);

        } else {
            header("Location: ..");
        }
    }

    protected function roomOpening($roomUrl): void
    {
        $roomStatus = mysqli_query($this->dbase, "SELECT roomOpen FROM `rooms` WHERE `room_url` = '$roomUrl'");
        if (mysqli_fetch_assoc($roomStatus)['roomOpen'] == "Closed") {
            mysqli_query($this->dbase, "UPDATE `rooms` SET roomOpen = 'Open' WHERE `room_url` = '$roomUrl'");
        }
    }

    protected function user_quit(ConnectionInterface $conn, $user, $roomUrl): void
    {
        $usersInRoom = $this->getUsersInRoom($roomUrl) - 1;
        \mysqli_query($this->dbase, "UPDATE `users` SET watching_room_url = NULL WHERE username = '$user'");
        \mysqli_query($this->dbase, "UPDATE `rooms` SET users_in_room = '$usersInRoom' WHERE room_url='$roomUrl'");
        $this->closingRoom($roomUrl);
    }

    private function getUsersInRoom($roomUrl): int
    {
        $users = \mysqli_query($this->dbase, "SELECT users_in_room FROM `rooms` WHERE room_url='$roomUrl'");
        return mysqli_fetch_assoc($users)['users_in_room'];
    }

    private function getRoomStatus($roomUrl): string
    {
        $roomStatus = \mysqli_query($this->dbase, "SELECT roomOpen FROM `rooms` WHERE room_url='$roomUrl'");
        return mysqli_fetch_assoc($roomStatus)['roomOpen'];
    }

    private function OpenRoomGetting(ConnectionInterface $conn, $user): void
    {
        $dbase = connecting();
        $all_rooms = mysqli_query($dbase, "SELECT creator, room_url FROM `rooms` WHERE roomOpen = 'Open'");
        $all_rooms_divs = array();
        $ResponseRooms = array(
            "event" => "openRooms"
        );
        foreach ($all_rooms as $room) {
            $all_rooms_divs[] = $room;

        }
        $ResponseRooms["rooms"] = $all_rooms_divs;
        $conn->send(json_encode($ResponseRooms));
    }

    protected function closingRoom($roomUrl): void
    {
        if ($this->getUsersInRoom($roomUrl) == 0 and $this->getRoomStatus($roomUrl) != 'Private') {
            \mysqli_query($this->dbase, "UPDATE `rooms` SET roomOpen = 'Closed' WHERE room_url='$roomUrl'");
        }
    }

    private function themeChanging(ConnectionInterface $conn, $theme, $user): void
    {
        \mysqli_query($this->dbase, "UPDATE `users` SET theme = '$theme' WHERE username='$user'");
    }

    private function themeFetching(ConnectionInterface $conn, $user): void
    {
        $theme = array(
            'event' => "theme"
        );
        $theme_result = \mysqli_query($this->dbase, "SELECT theme FROM `users` WHERE username = '$user'");
        $theme["current_theme"] = mysqli_fetch_assoc($theme_result)['theme'];
        $conn->send(json_encode($theme));
    }
}
