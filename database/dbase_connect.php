<?php
function connecting()
{
    $dbase = mysqli_connect("localhost", "root", "root", "main_table");
    if (!$dbase) {
        echo "Что-то не так";
    }
    return $dbase;
}