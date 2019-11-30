<?php
class Ws 
{
    CONST HOST = "127.0.0.1";
    CONST PORT = "8811";
    public $ws =null;
    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server(self::HOST, self::PORT);
        $this->ws->set([
            'worker_num'=>1,
            'task_worker_num'=>1
        ]);
        $this->ws ->on("start",[$this,"onStart"]);
        $this->ws ->on("workerstart",[$this,"onWorkerStart"]);
        $this->ws ->on("request",[$this,"onRequest"]);
        $this->ws ->on("open",[$this,"onOpen"]);
		$this->ws ->on("message",[$this,"onMessage"]);
        $this->ws ->on("task",[$this,"onTask"]);
        $this->ws ->on("finish",[$this,"onFinish"]);
        $this->ws ->on("close",[$this,"onClose"]);
        $this->ws ->start();
    } 
    public function onStart($server)
    {
        swoole_set_process_name("swoole_websocket_server");
    }
    public function onWorkerStart($server,$worker_id)
    {

    }
    public function onRequest($request,$response)
    {
        # code...
    }
    public function onOpen($ws,$request)
	{
        print_r($ws);

        // print_r($request);
	}
	public function onMessage($ws,$frame)
	{
        # code...
        // print_r($frame);
        $ws->push($frame->fd, "this is server");
	
	}
    public function onTask($serv,$taskID,$workerID,$data)
    {
        # code...
    }
    public function onFinish($serv,$taskID,$data)
    {
        # code...
    }
    public function onClose($ws,$fd)
    {
        echo "client {$fd} closed\n";
        # code...
    }
}
new Ws();