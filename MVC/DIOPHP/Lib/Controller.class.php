<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-12-09
 * 控制器基类 包含对视图的操作
 */
require('smarty/libs/Smarty.class.php');
class Controller extends Smarty{

    /**
     * Smarty实例化对象
     * @var string
     */
    protected $smarty;

    /**
     * 构造器
     */
    public function __construct(){
        $this->smarty = new Smarty();
        //模板界定符定义
        $this->smarty->left_delimiter  = getC('LEFT_DELIMITER');
        $this->smarty->right_delimiter = getC('RIGHT_DELIMITER');
        //模板目录
        $this->smarty->template_dir    = APP_PATH . MODULE_NAME . '/' . APP_TPL_DIRNAME . '/';
    }

    /**
     * 定义Smarty变量
     * @param string $key
     * @param mixed $value
     */
    public function assign($key,$value){
        $this->smarty->assign($key,$value);
    }

    /**
     * 模板输出
     */
    public function display($template = ''){
        $this->smarty->display($template);
    }
}