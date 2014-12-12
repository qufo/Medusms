<?php

/**
* 使用 phpunit --bootstrap=../../../bootstrap/autoload.php 进行测试
* 配置好 config 和 下面的手机号内容再测试。
*/
class SmsTest extends \TestCase{
    
    public function testTrue(){
        $this->assertTrue(true);
    }
    
    public function testGetBalance(){
        $balance = Medusms::getBalance();
        $this->assertTrue($balance>0);
    }
    
    public function testSend(){
        $mobile =''; //要发送的手机号
        $content=''; //要发送的内容
        $rrid = Medusms::send($mobile,$content);
        $this->assertTrue($rrid>1);
    }
    
}  
?>
