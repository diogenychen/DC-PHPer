<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-10-31
 * 数据库操作类
 */
class DioMySql{
    //TODO
    /**
     * 数据库连接项
     */
    protected $config = array(
        'DB_TYPE'       => 'mysql',
        'DB_HOST'       => '127.0.0.1',
        'DB_NAME'       => '',
        'DB_PORT'       => 3306,
        'DB_USER'       => 'root',
        'DB_PASSWD'     => 'root',
        'DB_CHARSET'    => 'utf8',
        'DB_PERSISTENT' => true,
    );

    /**
     * 当前连接数据库实例对象
     */
    protected $_intance = null;

    /**
     * 连接数据库对象
     */
    protected $conn;

    /**
     * 最后一条sql
     */
    protected $theLastSql = '';

    /**
     * 构造器
     */
    public function __construct($config){
        if(!empty($config) && is_array($config)){
            $this->config = array_merge($this->config,$config);
        }
        //检查参数
        if(empty($this->config['DB_HOST']) || empty($this->config['DB_USER'])){
            return null;
        }
        $this->connect();
    }

    /**
     * 连接数据库
     */
    public function connect(){
        if(empty($this->config)){
            die('the config is empty!');
        }
        try{
            if($this->config['DB_PERSISTENT']){
                $this->conn = mysql_pconnect($this->config['DB_HOST'],$this->config['DB_USER'],$this->config['DB_PASSWD']);
            }else{
                $this->conn = mysql_connect($this->config['DB_HOST'],$this->config['DB_USER'],$this->config['DB_PASSWD']);
            }
        }catch(Exception $e){
            die('Could not connected!' . mysql_error());
        }
        //选择数据库
        $this->selectDb($this->config['DB_NAME']) or die('db_name is error');
        //设置字符编码
        if($this->config['DB_CHARSET']){
            $this->charset($this->config['DB_CHARSET']);
        }else{
            $this->charset('utf8');
        }
    }

    /**
     * 静态方法 返回实例化对象
     */
    public function getInstance($config,$flag = false){
        if($this->_intance == null || $flag){
            $this->_intance = new DioMySql($config);
        }
        return $this->_intance;
    }
























    /**
     * 选择数据库
     */
    public function selectDb($name){
        return mysql_select_db($name,$this->conn);
    }

    /**
     * 切换数据库
     */
    public function changeDb($name){
        return mysql_query("USE {$name}");
    }

    /**
     * 设置数据库字符编码格式
     */
    public function charset($charset){
        return mysql_query("SET NAMES '{$charset}'");
    }

    /**
     * 销毁实例对象
     */
    public function destroyInstance()
    {
        return $this->_intance = null;
    }
}