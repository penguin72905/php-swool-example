## 进程守护程序

1. 程序需要监听到子进程的结束信号，以便于重新拉起新的子进程。
2. 子进程的运行环境需要独立于父进程。

## 使用swool函数介绍

~~~~
//https://wiki.swoole.com/wiki/page/263.html
bool Process->exec(string $execfile, array $args)
~~~~

让子进程蜕变成另一个系统调用程序，同时还能保证父进程与当前进程仍然是父子进程关系。

~~~
//https://wiki.swoole.com/wiki/page/220.html
array Process::wait(bool $blocking = true);
$result = array('code' => 0, 'pid' => 15001, 'signal' => 15);
~~~

等待子进程的退出信号

## 完整代码


~~~~

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
~~~~

$command 变量表示需要子进程脚本，通过 exec() 方法来启动成一个子进程的方式运行，再通过 Process::wait() 访求来等待 $command 这个子进程脚本结束，并回收进程资源。