<?php
class WebSocketServer{
    private $table;
    private $server;
    private $username =[
        '科比',
        '库里',
        'KD',
        'KG',
        '乔丹',
        '邓肯',
        '格林',
        '汤普森',
        '伊戈达拉',
        '麦迪',
        '艾弗森',
        '卡哇伊',
        '保罗'
    ];

    public function __construct()
    {
        // 内存表 实现进程间共享数据，也可以使用redis替代
        $this->table = new swoole_table(1024);
        $this->table->column('fd', swoole_table::TYPE_INT);
        $this->table->column('name', swoole_table::TYPE_STRING, 255);
        $this->table->create();
    }
    public function run(){
        $this->server =new swoole_websocket_server("0.0.0.0",9501);
        $this->server->on('open', [$this, 'open']);
        $this->server->on('message', [$this, 'message']);
        $this->server->on('close', [$this, 'close']);
        $this->server->start();
    }
    function open(swoole_websocket_server $server ,swoole_http_request $request){
        $user =[
            'fd'=>$request->fd,
            'name'=>array_rand($this->username,$request->fd)
        ];
        $this->table->set($request->fd,$user);

        //所有的用户
        $alluser = [];
        foreach ($this->table as $u){
            $alluser[]=$u;
        }

        print_r($alluser);

        $server->push($request->fd,json_encode(
            array_merge(
                ['type'=>'openok'],
                ['user'=>$user,'alluser'=>$alluser]
            )
        ));
    }

    function message(swoole_websocket_server $server ,swoole_websocket_frame $frame){
        $this->pushMessage($server, $frame->data, 'message', $frame->fd);
    }
    function pushMessage(swoole_websocket_server $server,string $message,string $type,int $fd){
        $message = htmlspecialchars($message);
        $datetime = date('Y-m-d H:i:s', time());
        $user = $this->table->get($fd);
        foreach ($this->table as $u){
            if($u['fd'] == $fd){
                continue;
            }
            //判断是否在线，如果在线才可以推送
            if($server->exist($u['fd'])){
                $server->push($u['fd'],json_encode([
                    'type'=>$type,
                    'data'=>$message,
                    'datetime'=>$datetime,
                    'user'=>$user
                ]));
            }

        }
    }
    function close(swoole_websocket_server $server,int $fd){
        $user = $this->table->get($fd);
        $this->pushMessage($server, "{$user['name']}离开聊天室", 'close', $fd);
        $this->table->del($fd);

    }

}
$server =new WebSocketServer();

$server->run();