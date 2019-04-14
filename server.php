<?php
//session_start();
//$username = $_SESSION["username"];

require "barrageConfig.php";


$server = new Swoole\WebSocket\Server("0.0.0.0", 9501);


$server->on('open', function ($server, $request) {
        //echo "server: handshake success with fd{$request->fd}\n";
    });

$server->on('close', function ($ser, $fd) {
        //echo "client {$fd} closed\n";
    });

$server->on('message', function ($server, $frame) {
        //echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        // $server->push($frame->fd, "this is server");
       
        $data = json_decode($frame->data);

        $userID = $data->userID;
        $string = filtration($data->record);
        date_default_timezone_set('PRC');
        $time = date("Y-m-d H:i:s");
        //session_start();
        //$username = $_SESSION["username"];
        $result = [
    		//"username" => $username,
    		"data" => $string,
    		"date" => $time 
	];
        //$server->push($frame->fd,$result);
        foreach ($server->connections as $fd){
            $server->push($fd,json_encode($result));
        }
        global $con;
        insert($con,$userID,$string,$time);
    });











$server->start();


?>
