<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-11-24
 * 短信宝接口整理类
 */
class SmsBao{

    /**
     * 短信宝账号密码
     */
    protected $account;
    protected $password;

    /**
     * 短信宝错误码
     */
    protected $errCode = array(
        0  => "短信发送成功",
        -1 => "参数不全",
        -2 => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        30 => "密码错误",
        40 => "账号不存在",
        41 => "余额不足",
        42 => "帐号过期",
        43 => "IP地址限制",
        50 => "内容含有敏感词",
        51 => "手机号码不正确",
    );

    /**
     * API接口
     */
    protected $sendMsgApi      = 'http://api.smsbao.com/sms';
    protected $queryBalanceApi = 'http://www.smsbao.com/query';

    /**
     * 构造器
     */
    public function __construct($account,$password){
        $account = trim($account);
        $password = trim($password);
        if(empty($account) || empty($password)){
            return -1;
        }
        $this->account = $account;
        $this->password = $password;
    }

    /**
     * 发送短信接口
     */
    public function sendMsg($mobile,$content){
        $mobile  = trim($mobile);
        $content = trim($content);
        if(empty($mobile) || empty($content)){
            return -1;
        }
        $params = array(
            'u' => $this->account,
            'p' => md5($this->password),
            'm' => $mobile,
            'c' => urlencode($content)
        );
        $url    = $this->sendMsgApi . "?" . http_build_query($params);
        $result = file_get_contents($url);
        return $result;
    }

    /**
     * 接收短信接口
     */
    public function receiveMsg($url,$mobile,$content){
        $url     = trim($url);
        $mobile  = trim($mobile);
        $content = trim($content);
        if(empty($url) || empty($mobile) || empty($content)){
            return -1;
        }
        $params = array(
            'm' => $mobile,
            'c' => urlencode($content)
        );
        $url    = $url . "?" . http_build_query($params);
        $result = file_get_contents($url);
        return $result;
    }

    /**
     * 查询余额接口
     */
    public function queryBalance(){
        $params = array(
            'u' => $this->account,
            'p' => md5($this->password),
        );
        $url    = $this->queryBalanceApi . "?" . http_build_query($params);
        $result = file_get_contents($url);
        $res    = substr($result,0,1);
        return $res;
    }

    /**
     * 获取错误信息
     */
    public function getErrMsg($code){
        return $this->errCode[$code];
    }

}