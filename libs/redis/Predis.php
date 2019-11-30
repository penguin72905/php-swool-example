<?php

class Predis
{
    public $redis="";
    public $conf=array(
        'host'=>"127.0.0.1",
        "port"=>"6379"
    );
    /**
     * 单例模式
     * @return void
     */
    private static $_instance=null;
    public function getInstance()
    {
        if(empty(self::$_instance)){
            self::$_instance =new self();
        }
        return self::$_instance;
    }

    private  function __construct($config=array())
    {
        $conf=array_merge($this->conf,$config);
        $this->redis=new \Redis();
        $result=$this->redis->connect($conf['host'], $conf['port']);
        if($result===false){
            throw new \Exception("redis connect error");
        }
    }
    /**
     * 设置key和value的值
     * 
     * @param [type] $key
     * @param [type] $value
     * @param integer $time
     * @return void
     */
    public function set($key,$value,$time=0)
    {
        if(!$key){
            return '';
        }
        if(is_array($value)){
            $value=json_encode($value);
        }
        if(!$time){
            return $this->redis->set($key,$value);
        }
        return $this->redis->setex($key,$time,$value);

    }
    /**
     * 为列表指定的索引赋新的值,若不存在该索引返回false.
     *
     * @param [type] $key
     * @param [type] $index
     * @param [type] $value
     * @return void
     */
    public function lset($key,$index,$value)
    {
        if(!$key || !$index){
            return '';
        }
        if(is_array($value)){
            $value=json_encode($value);
        }

        return $this->redis->lset($key,$index,$value);

    }
    /**
     * 由列表尾部添加字符串值。如果不存在该键则创建该列表。如果该键存在，而且不是一个列表，返回FALSE。
     *
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public function lpush($key,$value)
    {
        if(!$key){
            return '';
        }
        if(is_array($value)){
            $value=json_encode($value);
        }
        return $this->redis->lpush($key,$value);
    }
    /**
     * 由列表尾部添加字符串值。如果不存在该键则创建该列表。如果该键存在，而且不是一个列表，返回FALSE。
     *
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public function rpush($key,$value)
    {
        if(!$key){
            return '';
        }
        if(is_array($value)){
            $value=json_encode($value);
        }
        return $this->redis->rpush($key,$value);
    }

    /**
     * 为一个Key添加一个值。如果这个值已经在这个Key中，则返回FALSE。
     *
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public function sadd($key,$value)
    {
        if(!$key || !$value){
            return '';
        }
        if(is_array($value)){
            $value=json_encode($value);
        }

        return $this->redis->sadd($key,$value);

    }

    /**
     * 数字递减存储键值。
     *
     * @param [type] $key
     * @return void
     */
    public function decr($key)
    {
       if(!self::has($key)){
            return '';
       }
       return $this->redis->decr($key);
    }
    /**
     * 数字递增存储键值键.
     *
     * @param [type] $key
     * @return void
     */
    public function incr($key)
    {
       if(!self::has($key)){
            return '';
       }
       return $this->redis->incr($key);
    }

    /**
     * 获取有关指定键的值
     * 
     * @param [type] $key
     * @return void
     */
    public function get($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->get($key);
    }
    /**
     * 获取有关指定键的值返回指定键存储在列表中指定的元素。 0第一个元素，1第二个… -1最后一个元素，-2的倒数第二…错误的索引或键不指向列表则返回FALSE。
     * 
     * @param [type] $key
     * @return void
     */
    public function lget($key,$index)
    {
        if(!$key || !$index){
            return '';
        }
        return $this->redis->lget($key,$index);
    }
    /**
     * 返回在该区域中的指定键列表中开始到结束存储的指定元素，lGetRange(key, start, end)。0第一个元素，1第二个元素… -1最后一个元素，-2的倒数第二…
     *
     * @param [type] $key
     * @param [type] $start
     * @param [type] $end
     * @return void
     */
    public function lgetrange($key,$start,$end)
    {
        if(!$key){
            return '';
        }
        return $this->redis->lgetrange($key,$start,$end);
    }
    /**
     * 返回一个所有指定键的交集。如果只指定一个键，那么这个命令生成这个集合的成员。如果不存在某个键，则返回FALSE。
     *
     * @param [type] $key1
     * @param [type] $key2
     * @return void
     */
    public function sinter($key1, $key2)
    {
        if(!$key1 || !$key2){
            return '';
        }
        return $this->redis->sinter($key1, $key2);
    }

    /**
     * 验证指定的键是否存在
     *
     * @param [type] $key
     * @return boolean
     */
    public function has($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->exists($key);
    }
    /**
     * 检查集合中是否存在指定的值。
     *
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public function scontains($key,$value)
    {
        if(!$key || !$value){
            return '';
        }
        return $this->redis->scontains($key,$value);
    }

    /**
     * 返回的列表的长度。如果列表不存在或为空，该命令返回0。如果该键不是列表，该命令返回FALSE。
     *
     * @param [type] $key
     * @return void
     */
    public function lsize($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->lsize($key);
    }
    /**
     * 返回集合中存储值的数量
     *
     * @param [type] $key
     * @return void
     */
    public function ssize($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->ssize($key);
    }



    /**
     * 删除指定的键
     * 
     * @param [type] $key
     * @return void
     */
    public function delete($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->delete($key);
    }
    /**
     * 返回和移除列表的第一个元素
     * 
     * @param [type] $key
     * @return void
     */
    public function lpop($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->lpop($key);
    }
    /**
     * 随机移除并返回key中的一个值
     *
     * @param [type] $key
     * @return void
     */
    public function spop($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->spop($key);
    }
   /**
     * 从列表中从头部开始移除count个匹配的值。如果count为零，所有匹配的元素都被删除。如果count是负数，内容从尾部开始删除
     * 
     * @param [type] $key
     * @return void
     */
    public function lremove($key,$count,$value)
    {
        if(!$key || !$count || !$value){
            return '';
        }
        return $this->redis->lremove($key,$count,$value);
    }
    /**
     * 删除Key中指定的value值
     *
     * @param [type] $key
     * @param [type] $member
     * @return void
     */
    public function sremove($key,$member)
    {
        if(!$key || !$member ){
            return '';
        }
        return $this->redis->lremove($key,$member);
    }
    /**
     * 将Key1中的value移动到Key2中
     *
     * @param [type] $srcKey
     * @param [type] $dstKey
     * @param [type] $member
     * @return void
     */
    public function smove($srcKey ,$dstKey ,$member)
    {
        if(!$srcKey || !$dstKey|| !$member ){
            return '';
        }
        return $this->redis->smove($srcKey ,$dstKey ,$member);
    }
}