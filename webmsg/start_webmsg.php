<?php
$server = new Swoole\WebSocket\Server("127.0.0.1", 9501);

$server->on('open', function (Swoole\WebSocket\Server $server, $request) {
    if($request->fd){
        return;
    }
    echo "server: handshake success with fd{$request->fd}\n";
});

$server->on('message', function (Swoole\WebSocket\Server $server, $frame) {
    // 给所有发通知
    foreach ($server->connections as $fd) {
        $server->push($fd, $frame->data);
    }
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();