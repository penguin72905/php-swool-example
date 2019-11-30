<?php
$ws = new Swoole\WebSocket\Server("0.0.0.0", 9501);

$ws->on('open', function (Swoole\WebSocket\Server $ws, $request) {
    $fd=$request->fd;
    $GLOBALS['fd'][] = $fd;
});

$ws->on('message', function (Swoole\WebSocket\Server $ws, $frame) {
    $msg =  'from'.$frame->fd.":{$frame->data}\n";
    print_r($GLOBALS['fd']);
    // Array
    // (
    //     [0] => 1
    //     [1] => 2
    //     [2] => 3
    //     [3] => 4
    // )
    foreach($GLOBALS['fd'] as $fd){
        // 判断当前fd是否在线如果不在线，发送失败 无需处理
        if($ws->exist( $fd)){
            $ws->push($fd,$msg);
        }
    }
});

$ws->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$ws->start();