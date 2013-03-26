<?php
/*****************************************************************
 *
 * 短信发送类,最长70个字
 *
 * @example
 * $mobile = '13818794692';
 * $msg = str_repeat("我",70);
 * $ret = $this->send($mobile,$msg);
 * if(!$ret)
 *    $error = $this->error();
 *
 *****************************************************************/

class Sendmobile
{

    public $sn='SDK-BBX-010-14381';
    public $pwd='134679';

    public function doSendSMS($mobile,$content)
    {
        
        //请参考 'content'=>iconv( "UTF-8", "gb2312//IGNORE" ,$content),//短信内容

        $tmpDataAry = array( 
            'sn'=>$this->sn,
            'pwd'=>strtoupper(md5($this->sn.$this->pwd)),
            'mobile'=>$mobile,
            //'content'=>$content,
            'content'=>iconv( "UTF-8", "gb2312//IGNORE" ,$content),
            'ext'=>'',
            'rrid'=>'',
            'stime'=>''
        );

        $params = '';
        $flag = 0;

        //构造要post的字符串 
        foreach ($tmpDataAry as $key=>$value) { 
            if ($flag!=0) {
                $params .= "&"; 
                $flag = 1; 
            } 
            $params.= $key."=";
            $params.= urlencode($value); 
            $flag = 1; 
        }
        
        $length = strlen($params);
        
        //创建socket连接 
        $fp = fsockopen("sdk2.entinfo.cn",80,$errno,$errstr,10) or exit($errstr."--->".$errno);
        
        //构造post请求的头 
        $header = "POST /webservice.asmx/mt HTTP/1.1\r\n"; 
        $header .= "Host:sdk2.entinfo.cn\r\n"; 
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
        $header .= "Content-Length: ".$length."\r\n"; 
        $header .= "Connection: Close\r\n\r\n";
        
        //添加post的字符串 
        $header .= $params."\r\n";
        
        //发送post的数据 
        fputs($fp,$header); 
        $inheader = 1; 
        while (!feof($fp)) { 
            $line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据 
            if ($inheader && ($line == "\n" || $line == "\r\n")) { 
                $inheader = 0; 
            } 
            if ($inheader == 0) { 
                // echo $line; 
            } 
        }
        
        //<string xmlns="http://tempuri.org/">-5</string>
        $line=str_replace("<string xmlns=\"http://tempuri.org/\">","",$line);
        $line=str_replace("</string>","",$line);
        $result=explode("-",$line);
        if(count($result)>1){
            //echo 'error:'.$line;
            return false;
        }else{
            //echo 'success:'.$line;
            return true;
        }
    }
}
?>
