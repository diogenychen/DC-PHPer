<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-10-31
 * 框架初始配置
 *
 * 配置以数组的形式 最多是二维数组
 *
 * 该配置可以被应用配置覆盖
 */
return array(
    //模板信息配置
    'LEFT_DELIMITER'     => '{',
    'RIGHT_DELIMITER'    => '}',
    'TEMPLATES_CACHE_ON' => false,

    //默认模块配置
    'DEFAULT_MODULE'  => 'Home',
    'VAR_MODULE'      => 'm',
    'VAR_CONTROLLER'  => 'c',
    'VAR_ACTION'      => 'a',

);
