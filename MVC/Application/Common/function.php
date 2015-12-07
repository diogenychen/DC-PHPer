<?php
/**
 * @Author: DiogenyChen
 * @Createtime: 2015-10-31
 * 基础函数库
 */


/**
 * 讲string格式化为JSON前转义字符串
 */
function escapeJsonString($str){
    $escapers     = array("\\","/","\"","\n","\r","\t","\x08","\x0c");
    $replacements = array("\\\\","\\/","\\\"","\\n","\\t","\\f","\\b");
    $str          = str_replace($escapers,$replacements,$str);
    return $str;
}

/**
 * 设置超时的file_get_contents
 */
function to_file_get_contents($path){
    $options = array('http' => array(
        'timeout' => 30
    ));
    $stream = stream_context_create($options);
    return file_get_contents($path,'',$stream);
}

/**
 * 读取excel
 * @param string $filename
 * @param int $rowOffset
 * @return array
 */
function readExcel($filename, $rowOffset=0) {
    $excelReader = PHPExcel_IOFactory::createReader('Excel2007');//设定读取格式
    $excel = $excelReader->load($filename);
    $sheet = $excel->setActiveSheetIndex(0);//设定excel工作簿
    $output = array();
    foreach ($sheet->getRowIterator($rowOffset) as $row) {
        $tmp = array();
        foreach ($row->getCellIterator() as $key => $col) {
            //读取单元格
            $tmp[$key] = $col->getValue();
        }
        $output[] = $tmp;
    }
    return $output;
}

/**
 * 导出excel表格
 */
function importExcel(){
    //
}

/**
 * 获取指定字符长度的字符串
 * @param string $string
 * @param int $length
 * @param string $dot
 * @param string $charset 
 * @return string
 */
function getWord($string, $length, $dot = '',$charset='gbk') {
    
    if(strlen($string) <= $length) {
        return $string;
    }
    $string = str_replace(array('　','&nbsp;', '&', '"', '<', '>'), array('','','&', '"', '<', '>'), $string);
    $strcut = '';
    if(strtolower($charset) == 'utf-8') {
        $n = $tn = $noc = 0;
        while($n < strlen($string)) {
            $t = ord($string[$n]);
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 2;
            } elseif(224 <= $t && $t < 239) {
                $tn = 3; $n += 3; $noc += 2;
            } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 2;
            } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 2;
            } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 2;
            } else {
                $n++;
            }
            if($noc >= $length) {
                break;
            }
        }
        if($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
    } else {
        for($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
        }
    }
    
    return $strcut.$dot;
}

/**
 * 根据指定长度获取字符串 
 * @param string $string
 * @param int $length
 * @return string
 */
function getSubStr($string,$length){
    mb_convert_encoding($string, 'utf-8');
    $rs = '';
    $num = 0;
    for ($i = 0; $i < strlen($string); ) {
        $child = mb_substr($string, $i, 1);
        if((ord($child) >= 0 && ord($child) <=127)){
            $rs .= $child;
            $i++;
        }else{
            $rs .= mb_substr($string, $i,3);
            $i += 3;
        }
        $num++;

        if($num == $length){
            break;
        }
    }
    return $rs;
}


function safeEncoding($string,$outEncoding ='UTF-8')    
{    
    $encoding = "UTF-8";    
    for($i=0;$i<strlen($string);$i++)    
    {    
        if(ord($string{$i})<128)    
            continue;    
        
        if((ord($string{$i})&224)==224)    
        {    
            //第一个字节判断通过    
            $char = $string{++$i};    
            if((ord($char)&128)==128)    
            {    
                //第二个字节判断通过    
                $char = $string{++$i};    
                if((ord($char)&128)==128)    
                {    
                    $encoding = "UTF-8";    
                    break;    
                }    
            }    
        }    
    
        if((ord($string{$i})&192)==192)    
        {    
            //第一个字节判断通过    
            $char = $string{++$i};    
            if((ord($char)&128)==128)    
            {    
                // 第二个字节判断通过    
                $encoding = "GBK";    
                break;    
            }    
        }    
    }    
             
    if(strtoupper($encoding) == strtoupper($outEncoding))    
        return $string;    
    else   
        return iconv($encoding,$outEncoding,$string);    
}



