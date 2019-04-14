<?
$ini=parse_ini_file("config.ini");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin:'.$ini["frontendURL"]);
header('Content-Type: application/json');
//header('Access-Control-Allow-Headers:text/html')
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

function isNull($judge,$information){
    if($judge != null){
        return;
    }
    
    $result = [
        "errcode" => 2,
        "msg" => $information."不能为空",
        "data" => ""
    ];
    echo json_encode($result);
    exit;
}

function isSame($password,$checkpwd){
    if($password != $checkpwd){
        $result = [
            "errcode" => 3,
            "msg" => "两次密码不一致",
            "data" => ""
        ];
        echo json_encode($result);
        exit;
    }
}

function isExist($con,$username){
    $sql="SELECT username FROM information WHERE username=?";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"s",$username);
    mysqli_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    $row=mysqli_fetch_array($res);

    if($username == $row["username"]){
        $result = [
            "errcode" => 4,
            "msg" => "用户名已存在",
            "data" => ""
        ];
        echo json_encode($result);
        exit;
    }
}

function register($con,$username,$password){
    $sql="INSERT INTO information(username,`password`) VALUES (?,?)";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$username,$password);
    mysqli_execute($stmt);

    $result = [
        "errcode" => 0,
        "msg" => "注册成功",
        "data" => ""
    ];
    echo json_encode($result);
}


function login($con,$username,$password){
    $sql="SELECT `password` FROM information WHERE username=?";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"s",$username);
    mysqli_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    $row=mysqli_fetch_array($res);

    if($password == $row["password"]){
        $result = [
            "errcode" => 0,
            "msg" => "登陆成功",
            "data" => ""
        ];
    }else{
        $result = [
            "errcode" => 3,
            "msg" => "用户名或密码错误",
            "data" => ""
        ];
    }
    echo json_encode($result);
}

function searchID($con,$username){
    $sql="SELECT id FROM information WHERE username=?";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"s",$username);
    mysqli_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    $row=mysqli_fetch_array($res);
    return $row["id"];
}

function record($con){
    $sql="SELECT * FROM record ORDER BY `time` DESC";
    $stmt=mysqli_prepare($con,$sql);
    //mysqli_stmt_bind_param($stmt);
    mysqli_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    
    $arr=array();
    while($row=mysqli_fetch_array($res)){
        $arr[]=$row;
    }
    echo json_encode($arr);
}

function keySearch($con,$key){
    $sql="SELECT * FROM record WHERE record LIKE ? OR `time` LIKE ? ORDER BY `time` DESC";
    $string="%".$key."%";
    $time=$key."%";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$string,$time);
    mysqli_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);

    $arr=array();
    while($row=mysqli_fetch_array($res)){
        $arr[]=$row;
    }
    echo json_encode($arr);
    //echo $string;
}




?>
