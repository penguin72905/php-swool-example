


<?php

/*
 * 使用 swoole 启动子进程，并回收子进程资源
 */
$php = "/usr/local/php7/bin/php";
$script= __DIR__."/task.php";
//$command 变量表示需要子进程脚本，通过 exec() 方法来启动成一个子进程的方式运行
$command =  "{$php} {$script}";

/*
 * Process::signal设置异步信号监听。
 * Process::wait(false) 回收结束运行的子进程。
 * 访求来等待 $command 这个子进程脚本结束，并回收进程资源
 */
do{
    $process=new swoole_process(function (swoole_process $worker) use ($command){
        $worker->exec('/bin/sh', ['-c', $command]);
    });
    $process->start();
    $pid = $process->pid;
    printf("启动子进程 {$pid}\n");
}while(swoole_process::wait());