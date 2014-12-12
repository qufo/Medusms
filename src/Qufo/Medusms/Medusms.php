<?php namespace Qufo\Medusms;

/**
* 漫道SMS接口
* http://www.zucp.net/
*/
class Medusms {

    /**
    * 用户名
    * 
    * @var string
    */
    private $sn     = '';
    
    /**
    * 密码
    * 
    * @var string
    */
    private $pwd    = '';
    
    /**
    * 企业签名
    * 
    * @var string
    */
    private $sign   = '';
    
    /**
    * 扩展码
    * 
    * @var integer
    */
    private $ext    = '';
    
    /**
    * 发送服务器
    * @var string
    */
    private $host   = '';
    
    /**
    * 版本号
    */
    const VERSION = '0.1';

    
    /**
    * 初始化
    * 
    * @param string $sn 用户名
    * @param string $pwd 密码
    * @param string $sign 企业签名
    * @param integer $ext 扩展码
    * @param string $host 发送服务器
    * @return MeduSMS
    */
    public function __construct($sn='',$pwd='',$sign='',$ext='',$host='sdk2.entinfo.cn') {
        $this->sn       = $sn;
        $this->pwd      = $pwd;
        $this->sign     = $sign;
        $this->ext      = $ext;
        $this->host     = $host;
    }    



    /**
    * 取回短信条数余额
    * @return string 条数
    * 
    */
    public function getBalance(){
        $balance = $this->post('GetBalance',array('sn'=>$this->sn,'pwd'=>$this->pwd));
        return $balance;
    }
        
    
    /**
    * 发送手机短信
    * 
    * @param string $mobile 手机号码,群发时将手机号用","隔开。
    * @param string $content 内容
    * @param string $stime 发送时间 2014-12-12 01:23:45
    * @param string $rrid 唯一标识,全数字
    * @return string 唯一标识
    */
    public function send($mobile,$content,$stime='',$rrid=''){
        $params = array(
            'sn'    => $this->sn,
            'pwd'   => strtoupper(md5($this->sn.$this->pwd)),
            'mobile'=> $mobile,
            'content'=>iconv( "UTF-8", "gb2312//IGNORE" ,$content.$this->sign),
            'ext'   => $this->ext,
            'stime' => $stime,
            'rrid'  => $rrid
        );
        return $this->post('mt',$params);
    } 

    
    
    /**
    * 返回错误信息
    * 
    * @param mixed $code 错误代码
    * @return string 错误内容 ,如果没有错误返回 FALSE !!!
    */
    public function getError($code=0) {
        if ($code>1 || $code <-21) return false;
        $error = array(
            "1" =>"没有需要取得的数据",
            "-1"=>"重复注册",
            "-2"=>"帐号/密码不正确",
            "-4"=>"余额不足支持本次发送",
            "-5"=>"数据格式错误",
            "-6"=>"参数有误",
            "-7"=>"权限受限",
            "-8"=>"流量控制错误",
            "-9"=>"扩展码权限错误",
            "-10"=>"内容长度长",
            "-11"=>"内部数据库错误",
            "-12"=>"序列号状态错误",
            "-13"=>"没有提交增值内容",
            "-14"=>"服务器写文件失败",
            "-15"=>"文件内容base64编码错误",
            "-16"=>"返回报告库参数错误",
            "-17"=>"没有权限",
            "-18"=>"上次提交没有等待返回不能继续提交",
            "-19"=>"禁止同时使用多个接口地址",
            "-20"=>"相同手机号，相同内容重复提交",
            "-21"=>"Ip鉴权失败"      
        );
        if (isset($error[$code]))
            return $error[$code];
        else
            return false;
    }
           
    
    /**
    * 发送 post 请求
    * 
    * @param string $function 功能名称
    * @param array $params 参数
    */
    private function post($function='',$params=array()) {
        $params=http_build_query($params);
        $fp = fsockopen($this->host,8060,$errno,$errstr,10);
        if (!$fp) throw new Exception($errstr,$errno);
        
        $header  = "POST /webservice.asmx/".$function." HTTP/1.1\r\n"; 
        $header .= "Host:".$this->host."\r\n"; 
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
        $header .= "Content-Length: ".strlen($params)."\r\n"; 
        $header .= "Connection: Close\r\n\r\n"; 
        //添加post的字符串 
        $header .= $params."\r\n";
        //发送 Post 请求
        fputs($fp,$header);
        $inheader = 1;
        while(!feof($fp)) {
            $line = fgets($fp,1024);
            if ($inheader && ($line == "\n" || $line == "\r\n")) {
                $inheader = 0;
            }
        }
        $line = str_replace(array('<string xmlns="http://tempuri.org/">','</string>'),array('',''),$line);
        return trim($line);        
    }

    public function version(){
        return self::VERSION;
    }
           
}

?>
