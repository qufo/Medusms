Medusms
=======
漫道SMS

漫道短信发送包

installation
------------
For install this package Edit your project's ```composer.json``` file to require qufo/medusms

```php
"require": {
    "qufo/medusms": "dev-master"
},
```
Now, update Composer:
```
composer update
```
Once composer is finished, you need to add the service provider. Open ```app/config/app.php```, and add a new item to the providers array.
```
'Qufo\Medusms\MedusmsServiceProvider',
```
Next, add a Facade for more convenient usage. In ```app/config/app.php``` add the following line to the aliases array:
```
'Medusms'=> 'Qufo\Medusms\Facades\Medusms',
```
Publish config files:
```
php artisan config:publish qufo/medusms
```
for change sn, pwd,ext,sign and other configuration change ```app/config/packages/qufo/medusms/config.php```

Usage
-----
first, get sn,pwd from medusms provider.

then fill the config.php file
```php
return array(
    'sn'    => 'SDK-', //your sn
    'pwd'   => '',     //password for sn
    'ext'   => '',     // ext no 
    'sign'  => '',     //your signature like 【MyCompany】
    'host'  => 'sdk2.entinfo.cn' //service host . 
);
```

### Send Message
```php
Medusms::send('13800138000', 'I am here!'); // send message to 13800138000

Medusms::send('13800138000,13800138001','Hi, your two'); // send message to 13800138000 and 13800138001

```
the  send method return a rrid,it's a string build with numbers.

### Get Balance
```php
Medusms::getBalance(); // return your balance.
```



安装
------------
首选，编辑你项目的  ```composer.json``` 文件，加入 qufo/medusms 到 require 段

```php
"require": {
    "qufo/medusms": "dev-master"
},
```
然后，更新:
```
composer update
```
一旦 composer 更新完成, 需要修改 service provider.打开 ```app/config/app.php```, 在 providers 数组中加入一个新的项目.
```
'Qufo\Medusms\MedusmsServiceProvider',
```
接下来，加入 Facade，在  ```app/config/app.php``` 的 aliases 段中加入以下行：
```
'Medusms'=> 'Qufo\Medusms\Facades\Medusms',
```
发布配置文件:
```
php artisan config:publish qufo/medusms
```
变更用户帐号，密码，扩展码，签名信息等，更改 ```app/config/packages/qufo/medusms/config.php```

使用方法
-----
首先，从短信提供商那里获得用户帐号密码等并进行注册。

然后，将信息填入配置文件 ```app/config/packages/qufo/medusms/config.php```
```php
return array(
    'sn'    => 'SDK-', //帐号
    'pwd'   => '',     //密码
    'ext'   => '',     //扩展码
    'sign'  => '',     //签名 【我的公司】
    'host'  => 'sdk2.entinfo.cn' //接受服务的主机
);
```

### 发送短信
```php
Medusms::send('13800138000', 'I am here!'); // 发送短信到 13800138000

Medusms::send('13800138000,13800138001','Hi, your two'); // 发送短信给 13800138000 和 13800138001

```
返回值 rrid ，是一组数字组成的字符串。

### 取短信条数余额
```php
Medusms::getBalance(); // 返回余额
```

and enjoy it .