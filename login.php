<?php
session_start();
require "userConfig.php";

$username=htmlspecialchars($_POST["username"]);
$password=htmlspecialchars($_POST["password"]);

isNull($username,"用户名");
isNull($password,"密码");

login($con,$username,$password);

$_SESSION["username"] = $username;











?>
