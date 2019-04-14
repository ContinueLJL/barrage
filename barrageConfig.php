<?php
//$ini=parse_ini_file("config.ini");
//header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Allow-Origin:'.$ini["frontendURL"]);
//header('Content-Type: application/json');
$ini=parse_ini_file("config.ini");
$con=mysqli_connect($ini["servername"],$ini["username"],$ini["password"],$ini["dbname"]);
if(!$con){
    $result = [
        "errcode" => 1,
        "msg" => "连接错误",
        "data" => ""
    ];
    echo json_encode($result);
    exit;
}
mysqli_query($con,"SET NAMES utf8mb4");

function filtration($string){
    $myfile = fopen("chinese_dictionary.txt", "r") or die("Unable to open file!");//修改

    while(!feof($myfile)){
        $find = fgets($myfile);
        $find = str_replace("\n","",$find);
        $replace = "***";
        $string=str_replace($find,$replace,$string);
    }
    
    
    return $string;
}

function searchName($con,$userID){
    $sql="SELECT username FROM information WHERE id=?";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"i",$userID);
    mysqli_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    $row=mysqli_fetch_array($res);
    return $row["username"];
}

function insert($con,$userID,$record,$time){
    $username=searchName($con,$userID);
    $sql="INSERT INTO record(userID,username,record,`time`) VALUES (?,?,?,?)";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"isss",$userID,$username,$record,$time);
    mysqli_execute($stmt);
}




















?>
