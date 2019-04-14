<?php
require "userConfig.php";

$username=htmlspecialchars($_POST["username"]);
$password=htmlspecialchars($_POST["password"]);
$checkpwd=htmlspecialchars($_POST["checkpwd"]);

isNull($username,"用户名");
isNull($password,"密码");
isNull($checkpwd,"确认密码");

isSame($password,$checkpwd);

isExist($con,$username);

register($con,$username,$password);






?>
