<?php

require "userConfig.php";
session_start();
$username = $_SESSION["username"];
$userID = searchID($con,$username);
$result = [
    "errcode" => 0,
    "msg" => "",
    "data" => [
        "username" => $username,
        "userID" => $userID
    ]
];

echo json_encode($result);
//echo $username;












?>
