<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-10-19
 * @database class
 */
class LocalPdo{

    // 当前数据库连接实例
    static private $_instance = null;
    // 数据库连接实例
    static private $instance  = array();
    //PDO实例
    protected $pdo = null;
    //PDOStatement实例
    protected $pdoStatement = null;
    //最后执行SQL
    protected $theLastSql = '';
    // 最后插入ID
    protected $lastInsID  = null;

    // 数据库连接参数配置
    protected $config     = array(
        'DB_TYPE'              =>  'mysql',     // 数据库类型
        'DB_HOST'              =>  '127.0.0.1', // 服务器地址
        'DB_NAME'              =>  '',          // 数据库名
        'DB_USER'              =>  '',      // 用户名
        'DB_PWD'               =>  '',          // 密码
        'DB_POST'              =>  '',        // 端口
        'DB_DSN'               =>  '', //
        'DB_PARAMS'            =>  array(), // 数据库连接参数
        'DB_CHARSET'           =>  'utf8',      // 数据库编码默认采用utf8
        'DB_PREFIX'            =>  '',    // 数据库表前缀
        'DB_DEBUG'             =>  false, // 数据库调试模式
        'DB_DEPLOY'            =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'DB_RW_SEPARATE'       =>  false,       // 数据库读写是否分离 主从式有效
        'DB_MASTER_NUM'        =>  1, // 读写分离后 主服务器数量
        'DB_SLAVE_NO'          =>  '', // 指定从服务器序号
        'DB_LIKE_FIELDS'       =>  '',
        'DB_PERSISTENT'        => true  //长连接
    );
    // PDO连接参数
    protected $options = array(
        PDO::ATTR_CASE              =>  PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE           =>  PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS      =>  PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES =>  false,
    );

    /**
     * 构造器
     */
    public function __construct($config = array()){
        if (!class_exists('PDO')) return null;

        if(!empty($config)){
            $this->config = array_merge($this->config,$config);
        }
        if(empty($this->config['DB_NAME']) || empty($this->config['DB_USER'])){
            return null;
        }
        if(empty($this->config['DB_DSN'])){
            $this->config['DB_DSN'] = $this->config['DB_TYPE'] . ':host=' . $this->config['DB_HOST'] . ';dbname=' . $this->config['DB_NAME'];
        }
        if(!empty($this->config['DB_CHARSET'])){
            $this->config['DB_PARAMS'] = array(
                PDO::ATTR_PERSISTENT				 => $this->config['DB_PERSISTENT'],
                PDO::ATTR_ERRMODE			 		 => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND 		 => "SET NAMES '". $this->config['DB_CHARSET'] ."'",
            );
            $this->options = $this->config['DB_PARAMS'] + $this->options;
        }
        $this->dbConnect();
    }

    /**
     * 连接数据库
     */
    private function dbConnect(){
        try{
            $this->pdo = new PDO($this->config['DB_DSN'],$this->config['DB_USER'],$this->config['DB_PWD'],$this->options);  
        }catch(PDOException $e){ 
            return null;
        }
    }

    /**
     * 获取数据库连接实例
     */
    static function getInstance($config,$flag = false){
        if(self::$_instance == null || $flag){
            self::$_instance = new LocalPdo($config);
        }
        return self::$_instance;
    }

    /**
     * 切换数据库
     */
    public function changeDb($dbName){
        return $this->exec('use ' . $dbName);
    }

    /**
     * 关闭PDO实例
     */
    public function destroyDbh(){
        $this->pdo = null;
    }

    /**
     * 销毁数据库连接实例
     */
    public function destroyInstance(){
        self::$_instance = null;
    }

    /**
     * 执行SQL语句
     * @param $sql
     * @return pdoStatement
     */
    public function query($sql){
        if($this->pdo == null){
            $this->pdo = self::dbConnect();
        }
        $this->pdoStatement = null;
        $this->pdoStatement = $this->pdo->query($sql);
        $this->theLastSql = $sql;
        return $this->pdoStatement;
    }

    /**
     *执行sql语句并返回受影响行数
     * @param $sql
     * @return mixed
     */
    public function exec($sql){
        if($this->pdo == null){
            $this->pdo = self::dbConnect();
        }
        $this->pdoStatement = null;
        $this->theLastSql = $sql;
        try{
            $affectRow = $this->pdo->exec($sql);
            return $affectRow;
        }catch(PDOException $e){
            return false;
        }
    }

    /**
     * 预处理sql
     */
    public function prepare($sql){
        $this->pdoStatement = null;
        if($this->pdo == null){
            $this->dbConnect();
        }
        $this->pdoStatement = $this->pdo->prepare($sql);
        $this->theLastSql = $sql;
        return $this->pdoStatement;
    }

    /**
     * 执行预处理后的sql语句
     */
    public function execute($params = array()){
        return $this->pdoStatement->execute($params);
    }

    /**
     * 返回一行记录
     */
    public function fetchOne($style = PDO::FETCH_ASSOC){
        return $this->pdoStatement->fetch($style);
    }

    /**
     * 返回所有记录
     */
    public function fetchAll($style = PDO::FETCH_ASSOC){
        return $this->pdoStatement->fetchAll($style);
    }

    /**
     * 取得上一步 INSERT 操作产生的 ID
     * @return integer
     */
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    /**
     * 获取最后执行的sql语句
     */
    public function getLastSql(){
        return $this->theLastSql;
    }


















}