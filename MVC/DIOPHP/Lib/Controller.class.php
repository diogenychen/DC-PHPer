<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-12-09
 * 控制器基类 包含对视图的操作
 */
defined('SMARTY_DIR')          or define('SMARTY_DIR'   , LIB_PATH . 'smarty/libs/');
require(SMARTY_DIR. 'Smarty.class.php');

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
        $this->smarty->setTemplateDir(APP_PATH . MODULE_NAME . '/' . APP_TPL_DIRNAME . '/');
        //$this->smarty->setCacheDir(APP_PATH . MODULE_NAME . '/' . APP_RUNTIME_DIRNAME . '/cache/');
        //$this->smarty->setCompileDir(APP_PATH . MODULE_NAME . '/' . APP_RUNTIME_DIRNAME . '/templates_c/');
        //$this->smarty->setConfigDir(APP_PATH . MODULE_NAME . '/' . APP_RUNTIME_DIRNAME . '/configs/');
    }

    /**
     * 定义Smarty变量
     * @param string $key
     * @param mixed $value
     */
    public function assign($tpl_var, $value = NULL, $nocache = false){
        $this->smarty->assign($tpl_var,$value);
    }

    /**
     * 模板输出
     */
    public function display($template = NULL, $cache_id = NULL, $compile_id = NULL, $parent = NULL){
        $this->smarty->display($template);
    }






















}