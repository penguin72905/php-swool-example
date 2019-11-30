<?php

class SwooleWebSocket {
	CONST HOST="0.0.0.0";
	CONST PORT="9501";
	public $ws=null;
	function __construct()
	{
		$this->ws = new Swoole\WebSocket\Server(self::HOST, self::PORT);
		$this->ws ->on("open",[$this,"onOpen"]);
		$this->ws ->on("message",[$this,"onMessage"]);
		$this->ws ->on("close",[$this,"onClose"]);
		$this->ws->start();
	}
	public function onOpen($ws,$request)
	{
		var_dump($request->fd);
	}
	public function onMessage($ws,$frame)
	{

		swoole_timer_tick(3000, function () use ($ws,$frame) {
	    
			echo "定时执行";
	    		if($ws->isEstablished($frame->fd)){
					$ws->push($frame->fd, mt_rand(1,10));
				}else{
					echo $frame->fd."close";
				}
				
	    		
	 	});
		
	}
	public function onClose($ws,$fd)
	{
		 echo "client {$fd} closed\n";
	}


}
new SwooleWebSocket();
