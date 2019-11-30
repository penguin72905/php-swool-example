<?php
$ws = new Swoole\WebSocket\Server("0.0.0.0", 9501);

$ws->on('open', function (Swoole\WebSocket\Server $server, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
   $uid= $request->get['uid'];
   echo "uid=". $uid."/fd=". $request->fd. "\n";
   if($uid){
        $GLOBALS['user2fd'][$uid] = $request->fd;
   }


});

$ws->on('message', function (Swoole\WebSocket\Server $server, $frame) {
    // echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
  
    $data = json_decode($frame->data, true);

    print_r($data);


    print_r($GLOBALS['user2fd']);

    $msg= '收到一条新的回复,来自fd:'.$GLOBALS['user2fd'][$data['toUid']] ."内容是:".$data['content'];

    echo $msg ."\n";

    $server->push($GLOBALS['user2fd'][$data['toUid']], $msg);

});

$ws->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$ws->start();