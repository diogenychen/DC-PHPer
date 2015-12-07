<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-11-24
 * 数据库类
 */
class MySql {
    /**
     * 实例化对象
     */
    static $instance = null;

    /**
     * 内部数据链接对象
     */
    protected $conn;

    /**
     * 最后执行的SQL语句
     */
    protected $lastSql = '';

    /**
     * 执行SQL语句后的结果集
     */
    protected $queryRes = null;

    /**
     * 数据库链接项
     */
    protected $config = array(
        'DB_TYPE'       => 'mysql',
        'DB_HOST'       => '127.0.0.1',
        'DB_NAME'       => 'test',
        'DB_USER'       => 'root',
        'DB_PWD'        => '',
        'DB_PORT'       => '3306',
        'DB_PREFIX'     => '',
        'DB_CHARSET'    => 'utf8',
        'DB_PERSISTENT' => false
    );

    /**
     * 构造器
     */
    public function __construct($config){
        if(!function_exists('mysql_connect')){
            die('PHP do not support mysql database');
        }
        if(empty($config)){
            die('config is empty');
        }
        $this->config = array_merge($this->config,$config);
        $this->connect();
    }

    /**
     * 链接数据库
     */
    public function connect(){
        //判断是否长链接
        if($this->config['DB_PERSISTENT']){
            $this->conn = @mysql_pconnect($this->config['DB_HOST'],$this->config['DB_USER'],$this->config['DB_PWD']);
        }else{
            $this->conn = @mysql_connect($this->config['DB_HOST'],$this->config['DB_USER'],$this->config['DB_PWD']);
        }
        if(!$this->conn){
            die('mysql connect error' . mysql_error());
        }
        if(!@mysql_select_db($this->config['DB_NAME'],$this->conn)){
            die('database name do not exist');
        }
        if(empty($this->config['DB_CHARSET'])){
            mysql_query("SET NAMES 'utf8'");
        }else{
            mysql_query("SET NAMES '" . $this->config['DB_CHARSET']  . "'");
        }
    }

    /**
     * 切换数据库
     */
    public function changeDb($dbName){
        $dbName = trim($dbName);
        if(empty($dbName)){
            return false;
        }
        return mysql_query("use " . $dbName);
    }

    /**
     * 销毁实例
     */
    public function destroyInstance(){
        return self::$instance = null;
    }

    /**
     * 静态方法 返回数据库实例
     */
    public static function getInstance($config = null,$flag = false){
        if(self::$instance == null || $flag){
            self::$instance = new MySql($config);
        }
        return self::$instance;
    }

    /**
     * 获取最后执行的SQL
     */
    public function getLastSql(){
        return $this->lastSql;
    }

    /**
     * 获取一行
     */
    public function fetchOne(){
        if(empty($this->queryRes)){
            return array();
        }
        return mysql_fetch_assoc($this->queryRes);
    }

    /**
     * 获取全部数据
     */
    public function fetchAll(){
        if(empty($this->queryRes)){
            return array();
        }
        $data = array();
        while(($rows = mysql_fetch_assoc($this->queryRes)) !== false){
            $data[] = $rows;
        }
        return $data;
    }

    /**
     * 执行SQL语句
     */
    public function query($sql){
        $sql = trim($sql);
        if(empty($sql)){
            return false;
        }
        $this->queryRes = mysql_query($sql);
        $this->lastSql  = $sql;
        return $this->queryRes;
    }

    /**
     * 插入数据
     */
    public function insert($params,$tableName){
        if(!is_array($params) || empty($tableName)){
            return false;
        }
        $insertArr = array();
        foreach($params as $key => $val){
            if(is_numeric($val)){
                $insertArr[] = $key . " = " . $val;
            }else{
                $insertArr[] = $key . " = '" . mysql_real_escape_string($val) . "'";
            }
        }
        $insertStr = implode(",", $insertArr);
        $sql = "INSERT IGNORE INTO {$tableName} SET {$insertStr}";
        return $this->query($sql);
    }

    /**
     * 更新数据
     */
    public function update($set,$tableName,$where){
        if(!is_array($set) || empty($tableName) || empty($where)){
            return false;
        }
        $setArr = array();
        foreach($set as $key => $val){
            if(is_numeric($val)){
                $insertArr[] = $key . " = " . $val;
            }else{
                $insertArr[] = $key . " = '" . mysql_real_escape_string($val) . "'";
            }
        }
        $setStr = implode(",", $setArr);
        $sql = "UPDATE {$tableName} SET {$setStr} WHERE {$where}";
        return $this->query($sql);
    }

    /**
     * 删除数据
     */
    public function delete($where,$tableName,$limit = 1){
        if(empty($where) || empty($tableName)){
            return false;
        }
        $sql = "DELETE FROM {$tableName} WHERE {$where} LIMIT {$limit}";
        return $this->query($sql);
    }

    /**
     * 查询数据
     */
    public function select($where,$tableName){
        //
    }

















}